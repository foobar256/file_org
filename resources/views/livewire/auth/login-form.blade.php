<div style="max-width: 420px; margin: 2rem auto;">
  <h2 style="margin-bottom: 1rem;">Login</h2>
  <form wire:submit.prevent="login">
    <div style="margin-bottom: .75rem;">
      <label>Username</label>
      <input type="text" wire:model.defer="name" class="border" style="width:100%;padding:.5rem;">
      @error('name') <div style="color:#b91c1c">{{ $message }}</div> @enderror
    </div>
    <div style="margin-bottom: .75rem;">
      <label>Password</label>
      <input type="password" wire:model.defer="password" class="border" style="width:100%;padding:.5rem;">
      @error('password') <div style="color:#b91c1c">{{ $message }}</div> @enderror
    </div>
    <button type="submit" style="padding:.5rem 1rem;">Login</button>
  </form>
  <p style="margin-top:1rem;">No account? <a href="/register">Register</a></p>
</div>
