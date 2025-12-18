<x-layouts.dashboard :title="'Payments and billings'">
    <div x-data="{ showTopup: false }">
        <div class="grid sm:grid-cols-2 mb-10 gap-6">

            <!-- Wallet Balance Card -->
            <div class="bg-gradient-to-br from-[#68A3FF] to-[#407BFF] text-white rounded-3xl pt-8 relative overflow-hidden flex flex-col justify-center">

                <!-- Decorative Lines -->
                <div class="absolute inset-0  pointer-events-none bg-no-repeat bg-center"
                    style="background-image: url('{{ asset('images/pattern-wallet.png') }}'); background-size: cover; background-position:center;"></div>

                <div class="relative z-10 px-8 flex-1 py-8">
                    <h3 class="text-xl">Wallet balance</h3>

                    <p class="text-5xl lg:text-6xl mt-2 tracking-tight">
                        £5,756.<span class="text-3xl">00</span>
                    </p>

                </div>
                <!-- Bottom Section -->
                <div class="bg-white/10 px-8 flex flex-col flex-1 sm:flex-row items-center z-10">
                    <div class="flex lg:items-center justify-between w-full flex-col lg:flex-row gap-4">
                        <button @click="showTopup = true" class="bg-primary-dark text-white transition px-6 py-4 rounded-xl font-medium backdrop-blur-md w-full sm:max-w-[12rem]">
                            + Top up
                        </button>

                        <div class="text-left space-y-2">
                            <p class="text-xs sm:text-sm opacity-70">last top-up date</p>
                            <p class="text-sm sm:text-base font-medium">Wed 21st, May 2025</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="flex flex-col items-end gap-6 w-full">
                <!-- Currency Selector -->
                <x-currency-selector />

                <!-- Payment Stats Card -->
                <div class="bg-white rounded-3xl shadow-[0_0_25px_rgba(0,0,0,0.08)] p-8 flex-1 relative">

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 py-6">

                        <!-- Active Payment Methods -->
                        <div class="flex items-start gap-3">
                            <div class="size-12 rounded-xl bg-light-blue flex items-center justify-center">
                                <i class="fa-solid fa-credit-card text-primary"></i>
                            </div>

                            <div>
                                <p class="text-muted text-sm">Active payment methods</p>
                                <p class="text-xl font-bold mt-2 text-black">3</p>
                            </div>
                        </div>

                        <!-- Upcoming Payments -->
                        <div class="flex items-start gap-3">
                            <div class="size-12 rounded-xl bg-light-blue flex items-center justify-center">
                                <i class="fa-solid fa-clock-rotate-left text-primary"></i>
                            </div>

                            <div>
                                <p class="text-muted text-sm">Upcoming payments</p>
                                <p class="text-xl font-bold mt-2 text-black">5</p>
                            </div>
                        </div>

                        <!-- Last Payment -->
                        <div class="flex items-start gap-3">
                            <div class="size-12 rounded-xl bg-light-blue flex items-center justify-center">
                                <i class="fa-solid fa-file-invoice text-primary"></i>
                            </div>

                            <div>
                                <p class="text-muted text-sm">Last payment</p>
                                <p class="text-xl font-bold mt-2 text-black">24/03/2025</p>
                            </div>
                        </div>

                        <!-- Next Payment -->
                        <div class="flex items-start gap-3">
                            <div class="size-12 rounded-xl bg-light-blue flex items-center justify-center">
                                <i class="fa-solid fa-calendar-days text-primary"></i>
                            </div>

                            <div>
                                <p class="text-muted text-sm">Next payment</p>
                                <p class="text-xl font-bold mt-2 text-black">24/04/2025</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <x-ui.tab-group active="upcoming">

            <x-ui.tabs class="mb-10">
                <x-ui.tab name="upcoming">Upcoming payments</x-ui.tab>
                <x-ui.tab name="past">Past payment</x-ui.tab>
                <x-ui.tab name="methods">Payment Methods</x-ui.tab>
            </x-ui.tabs>

            <x-ui.tab-panel name="upcoming">
                @include('components.payments.upcoming')
            </x-ui.tab-panel>

            <x-ui.tab-panel name="past">
                @include('components.payments.past')
            </x-ui.tab-panel>

            <x-ui.tab-panel name="methods">
                @include('components.payments.methods')
            </x-ui.tab-panel>

        </x-ui.tab-group>

        <x-ui.modal show="showTopup" maxWidth="md">
            <x-slot name="header">
                <span class="text-xl font-semibold text-black">
                    Top-Up Card
                </span>


            </x-slot>

            <div
                x-data="{
                    open: false,
                    selected: {
                        code: 'GBP',
                        label: 'Pounds',
                        country: 'gb',
                    },
                    options: [
                        { code: 'GBP', label: 'Pounds', country: 'gb' },
                        { code: 'EUR', label: 'Euro', country: 'eu' },
                        { code: 'USD', label: 'Dollars', country: 'us' },
                    ]
                }"
                class="mt-6 flex gap-4">
                <!-- Currency selector -->
                <div class="relative">
                    <button
                        type="button"
                        @click="open = !open"
                        class="w-full flex max-w-[7.5rem] items-center justify-between gap-2 px-4 py-3 rounded-l-xl border bg-[#EDF6FF] border-[#EDF6FF] hover:border-[#EBEDF0]">
                        <div class="flex items-center gap-2">
                            <img
                                :src="`https://flagcdn.com/w20/${selected.country}.png`"
                                :alt="selected.label"
                                class="w-5 h-5 rounded-full object-cover">
                            <span class="text-sm font-medium" x-text="selected.code"></span>
                        </div>

                        <i class="fa-solid fa-chevron-down text-xs text-muted"></i>
                    </button>

                    <!-- Dropdown -->
                    <div
                        x-show="open"
                        x-transition
                        @click.outside="open = false"
                        class="absolute z-50 mt-2 w-40 rounded-xl border border-[#EBEDF0] bg-white shadow-lg">
                        <template x-for="option in options" :key="option.code">
                            <button
                                type="button"
                                @click="
                        selected = option;
                        open = false;
                    "
                                class="w-full flex items-center gap-3 px-4 py-3 text-sm hover:bg-[#EDF6FF]"
                                :class="selected.code === option.code ? 'bg-[#EDF6FF] font-medium' : ''">
                                <img
                                    :src="`https://flagcdn.com/w20/${option.country}.png`"
                                    :alt="option.label"
                                    class="w-5 h-5 object-cover rounded-full">

                                <!-- <span x-text="option.label"></span> -->

                                <span class="text-muted" x-text="option.code"></span>
                            </button>
                        </template>
                    </div>

                    <!-- Hidden input -->
                    <input type="hidden" name="currency" :value="selected.code">
                </div>

                <!-- Amount input -->
                <input
                    id="amout"
                    type="number"
                    placeholder="Enter top-up amount"
                    class="flex-1 px-4 py-3 rounded-xl border border-[#EBEDF0] bg-[#FAFAFA] focus:ring-0 focus:border-[#EDF6FF] w-full" />
            </div>



            <x-slot name="footer">
                <x-button variant="primary" class="w-full px-6 py-3.5 border-none" size="sm" onclick="gotoTopup()">
                    <span class="link-text back-text">Proceed</span>
                </x-button>
            </x-slot>


        </x-ui.modal>

    </div>



    @push("scripts")
    <script>
        function gotoTopup() {
            const amout = document.getElementById('amout').value;

            if (amout && amout <= 0) return;

            window.location.href = "/topup?amount=" + amout;
        }
    </script>
    @endpush
</x-layouts.dashboard>