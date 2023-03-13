<form method="POST" action="{{ route('user.register') }}" style="display: flex; flex-direction: column; align-items: center;">
    @csrf
    <div style="margin-bottom: 10px;">
        <label for="first_name" style="display: inline-block; width: 120px;">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required style="padding: 5px; font-size: 16px; border: 1px solid #ccc; border-radius: 3px;">
        @error('first_name')
        <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div style="margin-bottom: 10px;">
        <label for="last_name" style="display: inline-block; width: 120px;">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required style="padding: 5px; font-size: 16px; border: 1px solid #ccc; border-radius: 3px;">
        @error('last_name')
        <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div style="margin-bottom: 10px;">
        <label for="email" style="display: inline-block; width: 120px;">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required style="padding: 5px; font-size: 16px; border: 1px solid #ccc; border-radius: 3px;">
        @error('email')
        <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div style="margin-bottom: 10px;">
        <label for="password" style="display: inline-block; width: 120px;">Password:</label>
        <input type="password" name="password" id="password" required style="padding: 5px; font-size: 16px; border: 1px solid #ccc; border-radius: 3px;">
        @error('password')
        <span class="error" style="color: red;">{{ $message }}</span>
        @enderror
    </div>
    <div style="margin-bottom: 10px;">
        <label for="password_confirmation" style="display: inline-block; width: 120px;">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required style="padding: 5px; font-size: 16px; border: 1px solid #ccc; border-radius: 3px;">
    </div>
    <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 3px; font-size: 16px; cursor: pointer;">Register</button>
</form>

