<x-layouts.dashboard :title="'Settings'">

    <x-ui.tab-group active="preference" direction="horizontal">

        <x-ui.tabs variant="pill" direction="vertical" class="bg-white flex flex-1 flex-col justify-center h-[400px]">
            <x-ui.tab name="preference" variant="pill">Preference</x-ui.tab>
            <x-ui.tab name="notifications" variant="pill">Notifications</x-ui.tab>
            <x-ui.tab name="password" variant="pill">Change password</x-ui.tab>
        </x-ui.tabs>

        <x-ui.tab-panel name="preference" class="w-[75%] bg-white p-8 lg:p-12 lg:py-20 rounded-xl">
            <form class="space-y-10">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm text-muted">Currency</label>
                        <select class="w-full mt-2 border rounded-lg px-4 py-3">
                            <option>USD - United States Dollar</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm text-muted">Language</label>
                        <select class="w-full mt-2 border rounded-lg px-4 py-3">
                            <option>English (UK)</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm text-muted">Time zone</label>
                        <select class="w-full mt-2 border rounded-lg px-4 py-3">
                            <option>GMT +01 (Nigeria)</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm text-muted">Financial year</label>
                        <select class="w-full mt-2 border rounded-lg px-4 py-3">
                            <option>January - December</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end w-full mt-10">
                    <x-button class="w-full max-w-xs">
                        Save Changes
                    </x-button>

                </div>
            </form>
        </x-ui.tab-panel>

        <x-ui.tab-panel name="notifications" class="w-[75%] bg-white p-8 lg:p-12 lg:py-20 rounded-xl">
            <form method="post" class="space-y-6">

                <div class="flex items-center justify-between border-b border-[#EEEFF2] pb-6">
                    <div>
                        <p class="text-base text-black">Enable desktop notification</p>
                        <p class="text-sm text-muted">
                            Receive notifications for all messages, contracts, and documents.
                        </p>
                    </div>
                    <x-ui.switch-toggle />
                </div>

                <div class="flex items-center justify-between border-b border-[#EEEFF2] pb-6">
                    <div>
                        <p class="text-base text-black">Enable unread notification badge</p>
                        <p class="text-sm text-muted">
                            Show a red badge when you have unread messages.
                        </p>
                    </div>
                    <x-ui.switch-toggle />
                </div>

                <div class="border-b border-[#EEEFF2] pb-6">
                    <p class="text-base text-black mb-2">Push notification time-out</p>
                    <select class="border rounded-lg px-4 py-3 w-full text-black">
                        <option>10 minutes</option>
                    </select>
                </div>

                <div class="flex items-center justify-between border-b border-[#EEEFF2] pb-6">
                    <div>
                        <p class="text-base text-black">Communication emails</p>
                        <p class="text-sm text-muted">
                            Receive emails for messages, contracts, documents.
                        </p>
                    </div>
                    <x-ui.switch-toggle />
                </div>

                <div class="flex items-center justify-between border-b border-[#EEEFF2] pb-6">
                    <div>
                        <p class="text-base text-black">Announcements & updates</p>
                        <p class="text-sm text-muted">
                            Receive emails about product updates.
                        </p>
                    </div>

                    <x-ui.switch-toggle />
                </div>

                <div class="flex justify-end w-full mt-10">
                    <x-button class="w-full max-w-xs">
                        Save Changes
                    </x-button>
                </div>
            </form>
        </x-ui.tab-panel>

        <x-ui.tab-panel name="password" class="w-[75%] bg-white p-8 lg:p-12 lg:py-20 rounded-xl ">
            <form class="grid sm:grid-cols-3 md:grid-cols-5 gap-6">

                <div class="md:col-span-3 space-y-5">
                    <div>
                        <label class="text-sm text-muted">Current password</label>
                        <input
                            type="password"
                            class="w-full mt-2 border rounded-lg px-4 py-3" />
                    </div>

                    <div>
                        <label class="text-sm text-muted">New password</label>
                        <input
                            type="password"
                            class="w-full mt-2 border rounded-lg px-4 py-3" />
                    </div>

                    <div>
                        <label class="text-sm text-muted">Confirm password</label>
                        <input
                            type="password"
                            class="w-full mt-2 border rounded-lg px-4 py-3" />
                    </div>

                    <x-button class="w-full max-w-xs">
                        Save Changes
                    </x-button>

                </div>

                <div class="md:col-span-2 bg-[#FAFAFA] border border-[#E0E0E0] rounded-xl px-5 py-10 text-sm space-y-3">
                    <p class="font-medium text-sm text-black">Password must contain:</p>
                    <ul class="space-y-3 text-[#8E939C] text-xs">
                        <li class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full border border-gray-300 flex-shrink-0"></span>
                            At least 8 characters
                        </li>

                        <li class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full border border-gray-300 flex-shrink-0"></span>
                            At least 1 upper case letter (A-Z)
                        </li> 
                        <li class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full border border-gray-300 flex-shrink-0"></span>
                            At least 1 number (0-9)
                        </li> 
                        <li class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full border border-gray-300 flex-shrink-0"></span>
                            At least 1 symbol (!&#)
                        </li>
                    </ul>

                </div>

                </formx-show=>
        </x-ui.tab-panel>

    </x-ui.tab-group>

</x-layouts.dashboard>