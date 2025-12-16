@section('title', 'Personal Information - Remoteli')

<div class="step">
    <div class="mb-8">
        <h2 class="text-3xl font-medium text-black mb-2">Personal Information</h2>
        <p class="text-muted">Provide key personal information to establish your identity.</p>
    </div>

    <form method="POST" class="space-y-6" id="step1Form" onsubmit="submitStep(event, 1); return false;">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-muted mb-2">First name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}"
                    class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('first_name') border-danger  @enderror" required>

            </div>
            <div>
                <label class="block text-sm font-medium text-muted mb-2">Last name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}"
                    class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('last_name') border-danger  @enderror" required>

            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-muted mb-2">Email address</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('email') border-danger  @enderror" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-muted mb-2">Phone number</label>

            <x-ui.phone-input />


        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-muted mb-2">Date of birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                    class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-muted mb-2">Location</label>
                <x-ui.location-selector />

            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-muted mb-2">Address 1</label>
                <input type="text" name="address_1" value="{{ old('address_1') }}"
                    class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('address_1') border-danger  @enderror" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-muted mb-2">Address 2</label>
                <input type="text" name="address_2" value="{{ old('address_2') }}"
                    class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('address_2') border-danger  @enderror">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-muted mb-2">Password</label>
                <input type="password" name="password"
                    class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition @error('password') border-danger  @enderror" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-muted mb-2">Confirm password</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-4 py-3 border border-muted rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition" required>
            </div>
        </div>

        <div class="inline-flex justify-end gap-4 pt-4 w-full">
            <x-button type="button" class="w-full max-w-[14rem]" variant="outlined" onclick="prevStep()">
                Cancel
            </x-button>
            <x-button type="submit" class="w-full max-w-xs" variant="primary">
                Continue
            </x-button>
        </div>
    </form>

</div>