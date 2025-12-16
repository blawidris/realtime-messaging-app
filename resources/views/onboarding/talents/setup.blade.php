<x-layouts.app>

    <div class="w-full starry-background relative">
        <div class="absolute inset-0 bg-gradient-to-b from-[#40576D] to-[#0E253B] -z-10 w-full"></div>

        <div class="flex items-center justify-center flex-col mb-10 w-full">
            <div class="w-full max-w-7xl mx-auto mt-10 bg-white shadow-lg rounded-3xl">
                <!-- Progress Bar -->
                <div class="w-full bg-[#EDF6FF] rounded-t-3xl h-10">
                    <div id="progressBar" class="bg-blue-600 h-10 rounded-tl-3xl rounded-tr-3xl  rounded-br-3xl  w-1/6"></div>
                </div>

                <!-- Right Side - Form -->
                <div class=" p-8 lg:p-12 w-full max-w-5xl mx-auto">

                    @include("onboarding.talents.steps.personal-information")
                    @include("onboarding.talents.steps.profile-overview")
                    @include("onboarding.talents.steps.professional-information")
                    @include("onboarding.talents.steps.employment-history")
                    @include("onboarding.talents.steps.education-history")
                    @include("onboarding.talents.steps.preference-compliance")
                </div>
            </div>

        </div>

    </div>

    @push("scripts")

    <script>
        let currentStep = 1;
        const totalSteps = 6;

        function showStep(step) {
            document.querySelectorAll(".step").forEach((el, index) => {
                el.classList.add("hidden");
                if (index === step - 1) el.classList.remove("hidden");
            });
            document.getElementById("progressBar").style.width = (step / totalSteps) * 100 + "%";
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }

        // Submit step via AJAX (fetch)
        function submitStep(event, step) {
            event.preventDefault(); // 👈 stops page refresh

            let form;
            if (step === 1) form = document.getElementById('step1Form');
            if (step === 2) form = document.getElementById('step2Form');
            if (step === 3) form = document.getElementById('step3Form');
            if (step === 4) form = document.getElementById('step4Form');
            if (step === 5) form = document.getElementById('step5Form');
            if (step === 6) form = document.getElementById('step6Form');

            // Frontend validation
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const formData = new FormData(form);

            fetch(`/form-step/${step}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        "Accept": "application/json",

                    }
                })
                .then(res => res.json())
                .then(data => {

                    console.log("Response from step " + step + ":", data);
                    if (data.status === "success") {
                        if (currentStep < totalSteps) {
                            currentStep++;

                            console.log("Moving to step:", currentStep);
                            showStep(currentStep);
                        } else {
                            alert("Form successfully submitted!");
                        }
                    } else {
                        alert("Error: " + data.message);
                    }

                })
                .catch(err => console.error(err));
        }


        // Initialize
        showStep(currentStep);
    </script>

    @endpush

</x-layouts.app>