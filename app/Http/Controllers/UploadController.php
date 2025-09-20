<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function create()
    {
        return view('upload.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'max:10240'], // up to ~10MB
            'tags' => ['nullable', 'string'],
        ]);

        $file = $request->file('image');

        // Compute content hash to deduplicate
        $hash = hash_file('sha256', $file->getRealPath());

        // If a post with this hash already exists, just attach tags and return
        $existing = Post::where('image_hash', $hash)->first();

        $path = null;
        $post = $existing;

        if (!$existing) {
            $extension = $file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'bin';
            $filename = $file->getClientOriginalName();
            $mime = $file->getMimeType();
            $size = (int) $file->getSize();

            $storagePath = 'posts/'.$hash.'.'.$extension;

            // Store the file on the public disk so it can be served via /storage
            Storage::disk('public')->putFileAs('posts', $file, $hash.'.'.$extension);

            $path = $storagePath;

            $post = Post::create([
                'user_id' => Auth::id(),
                'path' => $path,
                'image_hash' => $hash,
                'filename' => $filename,
                'mime_type' => $mime,
                'size' => $size,
            ]);
        }

        // Parse tags (comma or space separated), normalize and attach
        $rawTags = (string) ($validated['tags'] ?? '');
        $parts = preg_split('/[\s,]+/', $rawTags, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $names = [];
        foreach ($parts as $t) {
            $name = trim($t);
            if ($name === '') {
                continue;
            }
            // Normalize: lowercase
            $names[] = mb_strtolower($name);
        }
        $names = array_values(array_unique($names));

        if (!empty($names)) {
            $tagIds = [];
            foreach ($names as $name) {
                $tag = Tag::firstOrCreate(['name' => $name]);
                $tagIds[] = $tag->id;
            }
            $post->tags()->syncWithoutDetaching($tagIds);
        }

        return redirect()->to('/upload')
            ->with('status', $existing ? 'Existing image found; tags updated.' : 'Image uploaded successfully.');
    }
}

