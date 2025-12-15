@section('title', 'Personal Information - Remoteli')


<div class="mb-8">
    <h2 class="text-3xl font-medium text-black mb-2">Personal Information</h2>
    <p class="text-muted">Provide key personal information to establish your identity.</p>
</div>

<form method="POST" class="space-y-6 step" id="step1Form">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-muted mb-2">First name</label>
            <input type="text" name="first_name" value="{{ old('first_name') }}"
                class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('first_name') border-red-500 @enderror" required>

        </div>
        <div>
            <label class="block text-sm font-medium text-muted mb-2">Last name</label>
            <input type="text" name="last_name" value="{{ old('last_name') }}"
                class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('last_name') border-red-500 @enderror" required>

        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-muted mb-2">Email address</label>
        <input type="email" name="email" value="{{ old('email') }}"
            class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-muted mb-2">Phone number</label>
        <div class="flex gap-2">
            <select name="country_code" class="px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                <option value="+233" {{ old('country_code') == '+233' ? 'selected' : '' }}>🇬🇭 +233</option>
                <option value="+234" {{ old('country_code') == '+234' ? 'selected' : '' }}>🇳🇬 +234</option>
                <option value="+254" {{ old('country_code') == '+254' ? 'selected' : '' }}>🇰🇪 +254</option>
                <option value="+27" {{ old('country_code') == '+27' ? 'selected' : '' }}>🇿🇦 +27</option>
            </select>
            <input type="tel" name="phone" value="{{ old('phone') }}"
                class="flex-1 px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('phone') border-red-500 @enderror" required>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-muted mb-2">Date of birth</label>
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
        </div>
        <div>
            <label class="block text-sm font-medium text-muted mb-2">Location</label>
            <select name="location" class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('location') border-red-500 @enderror" required>
                <option value="">Select location</option>
                <option value="Ghana" {{ old('location') == 'Ghana' ? 'selected' : '' }}>🇬🇭 Ghana</option>
                <option value="Nigeria" {{ old('location') == 'Nigeria' ? 'selected' : '' }}>🇳🇬 Nigeria</option>
                <option value="Kenya" {{ old('location') == 'Kenya' ? 'selected' : '' }}>🇰🇪 Kenya</option>
            </select>

        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-muted mb-2">Password</label>
            <input type="password" name="password"
                class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('password') border-red-500 @enderror" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-muted mb-2">Confirm password</label>
            <input type="password" name="password_confirmation"
                class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition" required>
        </div>
    </div>

    <div class="inline-flex justify-end gap-4 pt-4 w-full">
        <a href=".." class="flex-1 w-full max-w-xs bg-white border-2 border-muted text-black font-semibold py-4 rounded-xl hover:bg-blacktransition text-center">
            Cancel
        </a>
        <button type="submit" class="flex-1 w-full max-w-xs bg-blue-500 text-white font-semibold py-4 rounded-xl hover:bg-blue-600 transition">
            Continue
        </button>
    </div>
</form>