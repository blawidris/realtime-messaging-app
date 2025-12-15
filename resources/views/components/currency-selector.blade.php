<style>
    .currency-btn.active {
        background-color: #407BFF;
        color: white;
        border-radius: 9999px;
        font-weight: 600;
    }
</style>


@php
$countryLogos = [
["flag" => "https://flagsapi.com/GB/flat/24.png", "currency" => "£", 'default' => true],
["flag" => "https://flagsapi.com/US/flat/24.png", "currency" => "$"],
["flag" => "https://webtools.europa.eu/images/flags/eu.svg", "currency" => "€"]
];
@endphp


<div class="bg-white rounded-full flex items-center gap-2">

    @foreach ($countryLogos as $logo)
    <button
        class="currency-btn flex items-center gap-2 py-4 px-2 text-[#232325] transition 
            {{ isset($logo['default']) ? 'active' : 'hover:text-primary' }}">

        <span class="text-xl">{{ $logo['currency'] }}</span>
        <img src="{{ $logo['flag'] }}" class="size-8 rounded-full">
    </button>
    @endforeach

</div>


@push('scripts')
<script>
    document.querySelectorAll(".currency-btn").forEach(btn => {
        btn.addEventListener("click", () => {

            // Remove active from all
            document.querySelectorAll(".currency-btn")
                .forEach(b => b.classList.remove("active"));

            // Add active to clicked one
            btn.classList.add("active");
        });
    });
</script>
@endpush