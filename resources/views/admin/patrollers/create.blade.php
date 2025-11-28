@extends('layouts.app')

@section('title', 'Create Patroller - Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-teal-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white cinzel-heading">Create New Patroller</h1>
            <p class="text-blue-200 mt-2">Add a new patroller account to the system</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
            <form action="{{ route('admin.patrollers.store') }}" method="POST" class="p-6 space-y-6" id="create-patroller-form">
                @csrf
                
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white cinzel-subheading">Basic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name *</label>
                            <input type="text" id="name" name="name" required 
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter full name">
                            @error('name')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-300 mb-2">Username *</label>
                            <input type="text" id="username" name="username" required 
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Choose a username">
                            @error('username')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" required 
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter email address">
                            @error('email')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone" 
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter phone number">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white cinzel-subheading">Password</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password *</label>
                            <input type="password" id="password" name="password" required 
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter password"
                                   minlength="8">
                            @error('password')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required 
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Confirm password">
                            <p id="password-match-error" class="hidden mt-1 text-sm text-red-400">Passwords do not match.</p>
                            @error('password_confirmation')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Patroller Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white cinzel-subheading">Patroller Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="badge_number" class="block text-sm font-medium text-gray-300 mb-2">Badge Number</label>
                            <input type="text" id="badge_number" name="badge_number" 
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter badge number">
                            @error('badge_number')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="department" class="block text-sm font-medium text-gray-300 mb-2">Department</label>
                            <select id="department" name="department" 
                                    class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="Field Operations">Field Operations</option>
                                <option value="Research & Conservation">Research & Conservation</option>
                                <option value="Education & Outreach">Education & Outreach</option>
                                <option value="Rescue & Rehabilitation">Rescue & Rehabilitation</option>
                            </select>
                            @error('department')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="emergency_contact" class="block text-sm font-medium text-gray-300 mb-2">Emergency Contact</label>
                            <input type="text" id="emergency_contact" name="emergency_contact" 
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Emergency contact name">
                            @error('emergency_contact')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="emergency_phone" class="block text-sm font-medium text-gray-300 mb-2">Emergency Phone</label>
                            <input type="tel" id="emergency_phone" name="emergency_phone" 
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Emergency contact phone">
                            @error('emergency_phone')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Patrol Areas -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white cinzel-subheading">Patrol Areas</h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Assigned Patrol Areas</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <label class="flex items-center space-x-2 text-gray-300">
                                <input type="checkbox" name="patrol_areas[]" value="Coastal Zone A" class="rounded border-white/20 bg-white/10 text-blue-600 focus:ring-blue-500">
                                <span>Coastal Zone A</span>
                            </label>
                            <label class="flex items-center space-x-2 text-gray-300">
                                <input type="checkbox" name="patrol_areas[]" value="Coastal Zone B" class="rounded border-white/20 bg-white/10 text-blue-600 focus:ring-blue-500">
                                <span>Coastal Zone B</span>
                            </label>
                            <label class="flex items-center space-x-2 text-gray-300">
                                <input type="checkbox" name="patrol_areas[]" value="Nesting Beach 1" class="rounded border-white/20 bg-white/10 text-blue-600 focus:ring-blue-500">
                                <span>Nesting Beach 1</span>
                            </label>
                            <label class="flex items-center space-x-2 text-gray-300">
                                <input type="checkbox" name="patrol_areas[]" value="Nesting Beach 2" class="rounded border-white/20 bg-white/10 text-blue-600 focus:ring-blue-500">
                                <span>Nesting Beach 2</span>
                            </label>
                            <label class="flex items-center space-x-2 text-gray-300">
                                <input type="checkbox" name="patrol_areas[]" value="Marine Sanctuary" class="rounded border-white/20 bg-white/10 text-blue-600 focus:ring-blue-500">
                                <span>Marine Sanctuary</span>
                            </label>
                            <label class="flex items-center space-x-2 text-gray-300">
                                <input type="checkbox" name="patrol_areas[]" value="Rehabilitation Center" class="rounded border-white/20 bg-white/10 text-blue-600 focus:ring-blue-500">
                                <span>Rehabilitation Center</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Bio -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-white cinzel-subheading">Bio & Notes</h3>
                    
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-300 mb-2">Biography / Notes</label>
                        <textarea id="bio" name="bio" rows="4" 
                                  class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Enter biography or additional notes about the patroller"></textarea>
                        @error('bio')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-white/10">
                    <a href="{{ route('admin.patrollers.index') }}" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Create Patroller Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    const errorMessage = document.getElementById('password-match-error');
    const form = document.getElementById('create-patroller-form');

    const toggleError = (show) => {
        if (!errorMessage) {
            return;
        }
        if (show) {
            errorMessage.classList.remove('hidden');
        } else {
            errorMessage.classList.add('hidden');
        }
    };

    const passwordsMatch = () => {
        if (!password || !confirmPassword) {
            return true;
        }
        // Only validate when both fields have values to avoid distracting errors
        if (!password.value || !confirmPassword.value) {
            return true;
        }
        return password.value === confirmPassword.value;
    };

    const validatePasswords = () => {
        const matches = passwordsMatch();
        toggleError(!matches);
        return matches;
    };

    if (password) {
        password.addEventListener('input', validatePasswords);
    }

    if (confirmPassword) {
        confirmPassword.addEventListener('input', validatePasswords);
    }

    if (form) {
        form.addEventListener('submit', (event) => {
            if (!validatePasswords()) {
                event.preventDefault();
                confirmPassword.focus();
            }
        });
    }
});
</script>
@endpush
