@extends('layouts.app')

@section('title', 'Edit Patroller - ' . $patroller->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Patroller</h1>
                <p class="text-gray-600">Update patroller information and settings</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('admin.patrollers.profile', $patroller->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View Profile
                </a>
                <a href="{{ route('admin.patrollers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Patrollers
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.patrollers.update', $patroller->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $patroller->name) }}" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username', $patroller->username) }}" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $patroller->email) }}" required
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $patroller->phone) }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="badge_number" class="block text-sm font-medium text-gray-700">Badge Number</label>
                        <input type="text" id="badge_number" name="badge_number" value="{{ old('badge_number', $patroller->badge_number) }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('badge_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
                        <select id="department" name="department" 
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="Field Operations" {{ old('department', $patroller->patrollerProfile->department ?? '') == 'Field Operations' ? 'selected' : '' }}>Field Operations</option>
                            <option value="Research & Monitoring" {{ old('department', $patroller->patrollerProfile->department ?? '') == 'Research & Monitoring' ? 'selected' : '' }}>Research & Monitoring</option>
                            <option value="Education & Outreach" {{ old('department', $patroller->patrollerProfile->department ?? '') == 'Education & Outreach' ? 'selected' : '' }}>Education & Outreach</option>
                            <option value="Rescue & Rehabilitation" {{ old('department', $patroller->patrollerProfile->department ?? '') == 'Rescue & Rehabilitation' ? 'selected' : '' }}>Rescue & Rehabilitation</option>
                            <option value="Administration" {{ old('department', $patroller->patrollerProfile->department ?? '') == 'Administration' ? 'selected' : '' }}>Administration</option>
                        </select>
                        @error('department')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea id="bio" name="bio" rows="4" 
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('bio', $patroller->bio) }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Patrol Information -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Patrol Information</h3>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Patrol Areas</label>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="patrol_area_1" name="patrol_areas[]" value="Bagacay Turtle Sanctuary" 
                                   {{ in_array('Bagacay Turtle Sanctuary', old('patrol_areas', $patroller->patrol_areas ?? [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="patrol_area_1" class="ml-2 text-sm text-gray-700">Bagacay Turtle Sanctuary</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="patrol_area_2" name="patrol_areas[]" value="Punta Dumalag Turtle Sanctuary" 
                                   {{ in_array('Punta Dumalag Turtle Sanctuary', old('patrol_areas', $patroller->patrol_areas ?? [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="patrol_area_2" class="ml-2 text-sm text-gray-700">Punta Dumalag Turtle Sanctuary</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="patrol_area_3" name="patrol_areas[]" value="Nagtabon Beach Patrol" 
                                   {{ in_array('Nagtabon Beach Patrol', old('patrol_areas', $patroller->patrol_areas ?? [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="patrol_area_3" class="ml-2 text-sm text-gray-700">Nagtabon Beach Patrol</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="patrol_area_4" name="patrol_areas[]" value="Tawi-Tawi Marine Sanctuary" 
                                   {{ in_array('Tawi-Tawi Marine Sanctuary', old('patrol_areas', $patroller->patrol_areas ?? [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="patrol_area_4" class="ml-2 text-sm text-gray-700">Tawi-Tawi Marine Sanctuary</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="patrol_area_5" name="patrol_areas[]" value="Bataan Turtle Rescue Center" 
                                   {{ in_array('Bataan Turtle Rescue Center', old('patrol_areas', $patroller->patrol_areas ?? [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="patrol_area_5" class="ml-2 text-sm text-gray-700">Bataan Turtle Rescue Center</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="patrol_area_6" name="patrol_areas[]" value="Puerto Princesa Education Center" 
                                   {{ in_array('Puerto Princesa Education Center', old('patrol_areas', $patroller->patrol_areas ?? [])) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="patrol_area_6" class="ml-2 text-sm text-gray-700">Puerto Princesa Education Center</label>
                        </div>
                    </div>
                    @error('patrol_areas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="emergency_contact" class="block text-sm font-medium text-gray-700">Emergency Contact</label>
                        <input type="text" id="emergency_contact" name="emergency_contact" 
                               value="{{ old('emergency_contact', $patroller->patrollerProfile->emergency_contact ?? '') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('emergency_contact')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="emergency_phone" class="block text-sm font-medium text-gray-700">Emergency Phone</label>
                        <input type="tel" id="emergency_phone" name="emergency_phone" 
                               value="{{ old('emergency_phone', $patroller->patrollerProfile->emergency_phone ?? '') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        @error('emergency_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Status -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Account Status</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex items-center h-5">
                        <input id="is_active" name="is_active" type="checkbox" {{ $patroller->is_active ? 'checked' : '' }}
                               class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_active" class="font-medium text-gray-700">Active Account</label>
                        <p class="text-gray-500">Enable or disable the patroller's account access</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.patrollers.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Update Patroller
            </button>
        </div>
    </form>
</div>
@endsection
