<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Upload</title>
  <link rel="stylesheet" href="{{ asset('css/pico.min.css') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial; padding:2rem;">
  <main style="max-width: 640px; margin: 0 auto;">
    <header style="display:flex; justify-content: space-between; align-items:center; margin-bottom:1rem;">
      <h2 style="margin:0;">Upload Image</h2>
      <a href="/" aria-label="Home">Home</a>
    </header>

    @if (session('status'))
      <div style="background:#ecfdf5;color:#065f46;padding:.75rem 1rem;border:1px solid #a7f3d0;border-radius:.375rem;margin-bottom:1rem;">
        {{ session('status') }}
      </div>
    @endif

    <form action="{{ route('upload.store') }}" method="post" enctype="multipart/form-data">
      @csrf

      <div style="margin-bottom: .75rem;">
        <label for="image">Image</label>
        <input id="image" name="image" type="file" accept="image/*" required>
        @error('image') <div style="color:#b91c1c">{{ $message }}</div> @enderror
      </div>

      <div style="margin-bottom: .75rem;">
        <label for="tags">Tags (comma or space separated)</label>
        <input id="tags" name="tags" type="text" placeholder="e.g. cat, cute, meme" value="{{ old('tags') }}">
        @error('tags') <div style="color:#b91c1c">{{ $message }}</div> @enderror
      </div>

      <button type="submit" style="padding:.5rem 1rem;">Upload</button>
    </form>

    <section style="margin-top:2rem;">
      <h3>Recent Uploads</h3>
      <p style="color:#6b7280;">Uploaded files are saved to <code>storage/app/public/posts</code> and served via <code>/storage</code>.</p>
    </section>
  </main>
</body>
</html>

