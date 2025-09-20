<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Approve Posts</title>
  <link rel="stylesheet" href="{{ asset('css/pico.min.css') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial; padding:2rem;">
  <main style="max-width: 960px; margin: 0 auto;">
    <header style="display:flex; justify-content: space-between; align-items:center; margin-bottom:1rem;">
      <h2 style="margin:0;">Pending Approval</h2>
      <nav style="display:flex; gap:1rem;">
        <a href="/">Home</a>
        <a href="/upload">Upload</a>
      </nav>
    </header>

    @if (session('status'))
      <div style="background:#ecfdf5;color:#065f46;padding:.75rem 1rem;border:1px solid #a7f3d0;border-radius:.375rem;margin-bottom:1rem;">
        {{ session('status') }}
      </div>
    @endif

    @if ($posts->isEmpty())
      <p>No unapproved posts. 🎉</p>
    @else
      <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem;">
        @foreach ($posts as $post)
          <article style="border:1px solid #e5e7eb; border-radius:.5rem; overflow:hidden;">
            <div style="aspect-ratio: 1/1; display:flex; align-items:center; justify-content:center; background:#f9fafb;">
              <img src="{{ asset('storage/' . $post->path) }}" alt="upload" style="max-width:100%; max-height:100%; object-fit:contain;">
            </div>
            <div style="padding:.75rem;">
              <form action="{{ route('approve.post', $post) }}" method="post">
                @csrf
                <button type="submit" style="padding:.5rem 1rem;">Approve</button>
              </form>
            </div>
          </article>
        @endforeach
      </div>
    @endif
  </main>
</body>
</html>

