

<x-layouts.payment :pageTitle="$pageTitle">
  <x-slot name="content">
    <div class="bg-white p-8">
      <h1 class="text-2xl sm:text-[2rem] font-medium text-[#232325]">Top up</h1>
      <p class="text-sm text-muted mt-1">Terms and conditions</p>

      <div class="mt-6 space-y-6 text-sm text-black leading-relaxed">
        <section>
          <p class="font-medium">1. Eligibility</p>
          <ul class="list-disc ml-5 mt-2 space-y-1">
            <li>At least 18 years old.</li>
            <li>Authorized to use payment method.</li>
            <li>Registered platform user.</li>
          </ul>
        </section>

        <section>
          <p class="font-medium">2. Top-Up Process</p>
          <ul class="list-disc ml-5 mt-2 space-y-1">
            <li>Wallet credited after successful payment.</li>
            <li>Limits may apply.</li>
          </ul>
        </section>

        <section>
          <p class="font-medium">3. Fees and Charges</p>
          <ul class="list-disc ml-5 mt-2 space-y-1">
            <li>Processing fees may apply.</li>
            <li>Non-refundable after completion.</li>
          </ul>
        </section>
      </div>
    </div>

  </x-slot>

  <x-slot name="summary">
    <div class="p-8 sticky top-10">

      <h3 class="text-lg font-semibold">Summary</h3>

      <div class="mt-6 space-y-4 text-sm">
        <div class="flex justify-between">
          <span class="text-gray-500">Top up</span>
          <span>£<span x-text="{{ $amount }}.toLocaleString()"></span></span>
        </div>

        <div class="flex justify-between">
          <span class="text-gray-500">Charges</span>
          <span>£<span x-text="{{ $charges }}.toFixed(2)"></span></span>
        </div>

        <hr>

        <div class="flex justify-between font-semibold text-base">
          <span>Total:</span>
          <span>£<span x-text="{{ $total }}"></span></span>
        </div>
      </div>

      <div class="mt-8">
        <x-ui.card-info />
      </div>

      <x-button variant="primary" class="mt-8">
        Top up £<span x-text="{{ $total }}"></span>
      </x-button>

    </div>
  </x-slot>
</x-layouts.payment>