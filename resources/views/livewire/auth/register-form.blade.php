<div style="max-width: 420px; margin: 2rem auto;">
  <h2 style="margin-bottom: 1rem;">Register</h2>
  <form wire:submit.prevent="register">
    <div style="margin-bottom: .75rem;">
      <label>Name</label>
      <input type="text" wire:model.defer="name" class="border" style="width:100%;padding:.5rem;">
      @error('name') <div style="color:#b91c1c">{{ $message }}</div> @enderror
    </div>
    <div style="margin-bottom: .75rem;">
      <label>Password</label>
      <input type="password" wire:model.defer="password" class="border" style="width:100%;padding:.5rem;">
      @error('password') <div style="color:#b91c1c">{{ $message }}</div> @enderror
    </div>
    <div style="margin-bottom: .75rem;">
      <label>Confirm Password</label>
      <input type="password" wire:model.defer="password_confirmation" class="border" style="width:100%;padding:.5rem;">
    </div>
    <div style="margin-bottom: .75rem;">
      <label>Registration Hash</label>
      <input type="text" wire:model.defer="registration_hash" class="border" style="width:100%;padding:.5rem;">
      @error('registration_hash') <div style="color:#b91c1c">{{ $message }}</div> @enderror
    </div>
    <button type="submit" style="padding:.5rem 1rem;">Create account</button>
  </form>
  <p style="margin-top:1rem;">Already have an account? <a href="/login">Login</a></p>
</div>
