<form method="POST" action="{{ route('user.register') }}">
@csrf
<div>
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required>
    @error('first_name')
    <span class="error">{{ $message }}</span>
    @enderror
</div>
<div>
    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
    @error('last_name')
    <span class="error">{{ $message }}</span>
    @enderror
</div>
<div>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}" required>
    @error('email')
    <span class="error">{{ $message }}</span>
    @enderror
</div>
<div>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    @error('password')
    <span class="error">{{ $message }}</span>
    @enderror
</div>
<div>
    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required>
</div>
<button type="submit">Register</button>
</form>
