<x-layouts.app>

    <x-slot:sidebar>
        @include('components.onboarding-sidebar')
    </x-slot:sidebar>

    <div class="w-full  lg:w-1/2 bg-white p-6 sm:p-12">
        <a href=".." class="flex items-center space-x-2 text-muted hover:text-gray-800 transition-colors mb-8">
            <div class="rounded-full border border-muted">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
            </div>
            <span>Back</span>
        </a>

        <div class="w-full max-w-2xl">

            <div class="flex flex-col items-center justify-center py-10">

                <h2 class="text-3xl font-semibold mb-2">Join As A Client Or Candidate</h2>
                <p class="text-muted mb-8">Help us tailor your setup by choosing your account type.</p>


                <form id="signup-form" class="mt-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <!-- Client Card -->
                        <div id="client-card" class="border-2 rounded-3xl p-6 lg:p-10 cursor-pointer transition-all duration-300 flex flex-col items-center text-center h-full border-gray-200 bg-white hover:border-gray-300 hover:shadow-sm" role="button" aria-pressed="false">
                            <div class="size-16 flex items-center justify-center  mb-4 rounded-full border border-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <g clip-path="url(#clip0_12631_94658)">
                                        <path d="M16.2843 4.54368H15.2059C15.2059 2.85883 13.3192 1.48814 11 1.48814C8.68087 1.48814 6.79413 2.85887 6.79413 4.54368H5.7157C5.7157 3.41068 6.28515 2.35533 7.31911 1.572C8.30846 0.822448 9.61569 0.409668 11 0.409668C12.3843 0.409668 13.6916 0.822448 14.6809 1.57196C15.7149 2.35529 16.2843 3.41064 16.2843 4.54368Z" fill="url(#paint0_linear_12631_94658)" />
                                        <path d="M14.6809 1.57197C14.1795 1.1921 13.5962 0.899156 12.9628 0.702148V1.84192C14.2957 2.35508 15.2059 3.37351 15.2059 4.54365H16.2843C16.2843 3.41065 15.7149 2.3553 14.6809 1.57197Z" fill="url(#paint1_linear_12631_94658)" />
                                        <path d="M7.6315 3.89122L7.48233 3.83212C6.92474 3.6113 6.304 3.6113 5.7464 3.83212L5.59724 3.89122C5.33462 3.99522 5.16211 4.24908 5.16211 4.53155V6.02056C5.16211 6.40094 5.47045 6.70929 5.85084 6.70929H7.37794C7.75833 6.70929 8.06667 6.40094 8.06667 6.02056V4.53155C8.06663 4.24908 7.89412 3.99522 7.6315 3.89122Z" fill="url(#paint2_linear_12631_94658)" />
                                        <path d="M16.4028 3.89122L16.2536 3.83212C15.696 3.6113 15.0753 3.6113 14.5177 3.83212L14.3685 3.89122C14.1059 3.99522 13.9333 4.24908 13.9333 4.53159V6.0206C13.9333 6.40099 14.2417 6.70933 14.6221 6.70933H16.1492C16.5296 6.70933 16.8379 6.40099 16.8379 6.0206V4.53159C16.8379 4.24908 16.6654 3.99522 16.4028 3.89122Z" fill="url(#paint3_linear_12631_94658)" />
                                        <path d="M4.90112 22H3.95645C3.66139 22 3.42224 21.7608 3.42224 21.4658V20.6196H5.43533V21.4658C5.43533 21.7608 5.19613 22 4.90112 22Z" fill="url(#paint4_linear_12631_94658)" />
                                        <path d="M18.0437 22H17.099C16.804 22 16.5648 21.7608 16.5648 21.4658V20.6196H18.5779V21.4658C18.5779 21.7608 18.3387 22 18.0437 22Z" fill="url(#paint5_linear_12631_94658)" />
                                        <path d="M19.2557 21.3536H2.74418C1.44877 21.3536 0.398682 20.3034 0.398682 19.0081V7.91044C0.398682 6.61503 1.44882 5.56494 2.74418 5.56494H19.2558C20.5512 5.56494 21.6013 6.61507 21.6013 7.91044V19.008C21.6013 20.3034 20.5512 21.3536 19.2557 21.3536Z" fill="url(#paint6_linear_12631_94658)" />
                                        <path d="M21.6013 12.8369C21.0142 13.4241 20.2178 13.7539 19.3874 13.7539H0.844727L8.44426 21.3535H19.2558C20.5512 21.3535 21.6013 20.3033 21.6013 19.008V12.8369H21.6013Z" fill="url(#paint7_linear_12631_94658)" />
                                        <path d="M20.0484 14.1839L11.8008 14.8994C11.2679 14.9456 10.7321 14.9456 10.1992 14.8994L1.95157 14.1839C0.847518 14.0882 0 13.164 0 12.0557V7.10771C0 5.8123 1.05013 4.76221 2.3455 4.76221H19.6545C20.9499 4.76221 22 5.81234 22 7.10771V12.0558C22 13.164 21.1525 14.0882 20.0484 14.1839Z" fill="url(#paint8_linear_12631_94658)" />
                                        <path d="M0 8.58057V12.0558C0 13.1641 0.847518 14.0883 1.95157 14.1841L10.1992 14.8995C10.7321 14.9457 11.2679 14.9457 11.8008 14.8995L20.0484 14.1841C21.1525 14.0883 22 13.1641 22 12.0559V8.58061L0 8.58057Z" fill="url(#paint9_linear_12631_94658)" />
                                        <path d="M0.398682 15.918V19.0079C0.398682 20.3033 1.44882 21.3535 2.74418 21.3535H19.2558C20.5512 21.3535 21.6013 20.3033 21.6013 19.0079V15.918H0.398682Z" fill="url(#paint10_linear_12631_94658)" />
                                        <path d="M21.6014 15.6568V19.0077C21.6014 19.6314 21.3577 20.1987 20.9604 20.6188L16.1217 15.7801C15.9375 15.6943 15.8098 15.5079 15.8098 15.291V14.7919C15.6705 14.6642 15.5868 14.4817 15.5868 14.285V12.7959C15.5868 12.4154 15.8952 12.1074 16.2757 12.1074H17.8028C18.0599 12.1074 18.2837 12.2485 18.4019 12.4573L21.6014 15.6568Z" fill="url(#paint11_linear_12631_94658)" />
                                        <path d="M15.3055 21.353H9.70198L4.12951 15.7801C3.94531 15.6943 3.81762 15.5079 3.81762 15.291V14.7919C3.67829 14.6642 3.5946 14.4817 3.5946 14.285V12.7959C3.5946 12.4154 3.90304 12.1074 4.28351 12.1074H5.81057C6.06766 12.1074 6.29155 12.2485 6.40974 12.4573L15.3055 21.353Z" fill="url(#paint12_linear_12631_94658)" />
                                        <path d="M5.69302 15.7888H4.31483C4.01641 15.7888 3.77454 15.5469 3.77454 15.2485V14.3652H6.23336V15.2485C6.23332 15.5469 5.9914 15.7888 5.69302 15.7888Z" fill="url(#paint13_linear_12631_94658)" />
                                        <path d="M6.02107 14.8825L5.8719 14.9416C5.31431 15.1624 4.69357 15.1624 4.13597 14.9416L3.98676 14.8825C3.72414 14.7785 3.55164 14.5247 3.55164 14.2422V12.7532C3.55164 12.3728 3.85998 12.0645 4.24037 12.0645H5.76747C6.14785 12.0645 6.4562 12.3728 6.4562 12.7532V14.2422C6.45624 14.5247 6.28373 14.7785 6.02107 14.8825Z" fill="url(#paint14_linear_12631_94658)" />
                                        <path d="M17.6852 15.7888H16.307C16.0086 15.7888 15.7667 15.5469 15.7667 15.2485V14.3652H18.2255V15.2485C18.2255 15.5469 17.9836 15.7888 17.6852 15.7888Z" fill="url(#paint15_linear_12631_94658)" />
                                        <path d="M18.0132 14.8825L17.864 14.9416C17.3065 15.1624 16.6857 15.1624 16.1281 14.9416L15.9789 14.8825C15.7163 14.7785 15.5438 14.5247 15.5438 14.2422V12.7532C15.5438 12.3728 15.8522 12.0645 16.2326 12.0645H17.7597C18.14 12.0645 18.4484 12.3728 18.4484 12.7532V14.2422C18.4484 14.5247 18.2759 14.7785 18.0132 14.8825Z" fill="url(#paint16_linear_12631_94658)" />
                                        <path d="M18.2841 14.3368C15.5109 11.5388 13.2122 9.21738 13.1976 9.19538C13.1348 9.10086 13.0273 9.03857 12.9053 9.03857H9.18086C8.98718 9.03857 8.8302 9.19555 8.8302 9.38924V9.97603C8.8302 10.0729 8.86945 10.1605 8.93291 10.224C8.9531 10.2442 10.8794 12.1558 13.4958 14.7521L18.2841 14.3368Z" fill="url(#paint17_linear_12631_94658)" />
                                        <path d="M12.8622 10.2608H9.13777C8.94409 10.2608 8.78711 10.1038 8.78711 9.91011V9.32332C8.78711 9.12963 8.94413 8.97266 9.13777 8.97266H12.8623C13.056 8.97266 13.2129 9.12968 13.2129 9.32332V9.91011C13.2129 10.1038 13.0559 10.2608 12.8622 10.2608Z" fill="url(#paint18_linear_12631_94658)" />
                                        <path d="M13.6474 2.6905C11.8938 1.93352 10.1045 1.9343 8.35274 2.6905C8.07062 2.81227 7.74213 2.70482 7.5899 2.43789C7.43633 2.16867 7.28281 1.89949 7.12924 1.63027C6.9522 1.3199 7.08442 0.926529 7.41101 0.781501C9.75725 -0.260436 12.2424 -0.260565 14.5891 0.781501C14.9157 0.926529 15.0479 1.31985 14.8709 1.63027C14.7173 1.89949 14.5638 2.16867 14.4102 2.43789C14.2579 2.70478 13.9295 2.81227 13.6474 2.6905Z" fill="url(#paint19_linear_12631_94658)" />
                                    </g>
                                    <defs>
                                        <linearGradient id="paint0_linear_12631_94658" x1="11" y1="0.409668" x2="11" y2="4.54368" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#E6EEFF" />
                                            <stop offset="1" stop-color="#BAC8FA" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear_12631_94658" x1="15.6529" y1="3.6916" x2="14.6607" y2="2.78572" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#A7B7F1" stop-opacity="0" />
                                            <stop offset="1" stop-color="#A7B7F1" />
                                        </linearGradient>
                                        <linearGradient id="paint2_linear_12631_94658" x1="6.61433" y1="4.11225" x2="6.61433" y2="5.00562" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FEE45A" />
                                            <stop offset="1" stop-color="#FEA613" />
                                        </linearGradient>
                                        <linearGradient id="paint3_linear_12631_94658" x1="15.3857" y1="4.11225" x2="15.3857" y2="5.00562" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FEE45A" />
                                            <stop offset="1" stop-color="#FEA613" />
                                        </linearGradient>
                                        <linearGradient id="paint4_linear_12631_94658" x1="4.42881" y1="21.166" x2="4.42881" y2="21.8281" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#5A5A5A" />
                                            <stop offset="1" stop-color="#444444" />
                                        </linearGradient>
                                        <linearGradient id="paint5_linear_12631_94658" x1="17.5713" y1="21.166" x2="17.5713" y2="21.8281" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#5A5A5A" />
                                            <stop offset="1" stop-color="#444444" />
                                        </linearGradient>
                                        <linearGradient id="paint6_linear_12631_94658" x1="7.84469" y1="9.37767" x2="17.2486" y2="21.5424" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#C86D36" />
                                            <stop offset="1" stop-color="#883F2E" />
                                        </linearGradient>
                                        <linearGradient id="paint7_linear_12631_94658" x1="11.223" y1="19.0885" x2="11.223" y2="14.5318" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#883F2E" stop-opacity="0" />
                                            <stop offset="1" stop-color="#6D3326" />
                                        </linearGradient>
                                        <linearGradient id="paint8_linear_12631_94658" x1="6.62437" y1="6.88335" x2="17.495" y2="13.4402" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#C86D36" />
                                            <stop offset="1" stop-color="#883F2E" />
                                        </linearGradient>
                                        <linearGradient id="paint9_linear_12631_94658" x1="11" y1="10.5258" x2="11" y2="15.7052" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#883F2E" stop-opacity="0" />
                                            <stop offset="1" stop-color="#6D3326" />
                                        </linearGradient>
                                        <linearGradient id="paint10_linear_12631_94658" x1="11" y1="18.765" x2="11" y2="21.4137" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#883F2E" stop-opacity="0" />
                                            <stop offset="1" stop-color="#6D3326" />
                                        </linearGradient>
                                        <linearGradient id="paint11_linear_12631_94658" x1="22.4559" y1="17.8723" x2="17.4951" y2="15.3704" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#883F2E" stop-opacity="0" />
                                            <stop offset="1" stop-color="#6D3326" />
                                        </linearGradient>
                                        <linearGradient id="paint12_linear_12631_94658" x1="9.67907" y1="17.9774" x2="2.51829" y2="13.0598" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#883F2E" stop-opacity="0" />
                                            <stop offset="1" stop-color="#6D3326" />
                                        </linearGradient>
                                        <linearGradient id="paint13_linear_12631_94658" x1="5.0039" y1="15.0411" x2="5.0039" y2="15.7027" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FEE45A" />
                                            <stop offset="1" stop-color="#FEA613" />
                                        </linearGradient>
                                        <linearGradient id="paint14_linear_12631_94658" x1="4.65837" y1="12.7812" x2="5.4492" y2="14.4204" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FEE45A" />
                                            <stop offset="1" stop-color="#FEA613" />
                                        </linearGradient>
                                        <linearGradient id="paint15_linear_12631_94658" x1="16.9961" y1="15.0411" x2="16.9961" y2="15.7027" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FEE45A" />
                                            <stop offset="1" stop-color="#FEA613" />
                                        </linearGradient>
                                        <linearGradient id="paint16_linear_12631_94658" x1="16.6505" y1="12.7812" x2="17.4413" y2="14.4204" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FEE45A" />
                                            <stop offset="1" stop-color="#FEA613" />
                                        </linearGradient>
                                        <linearGradient id="paint17_linear_12631_94658" x1="14.7558" y1="14.1449" x2="11.2617" y2="8.49392" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#883F2E" stop-opacity="0" />
                                            <stop offset="1" stop-color="#6D3326" />
                                        </linearGradient>
                                        <linearGradient id="paint18_linear_12631_94658" x1="11" y1="9.28644" x2="11" y2="10.1837" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#E6EEFF" />
                                            <stop offset="1" stop-color="#BAC8FA" />
                                        </linearGradient>
                                        <linearGradient id="paint19_linear_12631_94658" x1="11" y1="0.401462" x2="11" y2="1.20602" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#5A5A5A" />
                                            <stop offset="1" stop-color="#444444" />
                                        </linearGradient>
                                        <clipPath id="clip0_12631_94658">
                                            <rect width="22" height="22" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-black mb-1">Client</h3>
                            <p class="text-base font-medium text-muted">I'm a client, hiring for a <br /> project</p>
                        </div>
                        <!-- Employment Card -->
                        <div id="employment-card" class="border-2 rounded-3xl p-6 lg:p-10 cursor-pointer transition-all duration-300 flex flex-col items-center text-center h-full border-gray-200 bg-white hover:border-gray-300 hover:shadow-sm" role="button" aria-pressed="false">
                            <div class="size-16 flex items-center justify-center  mb-4 rounded-full border border-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <g clip-path="url(#clip0_12631_94694)">
                                        <path d="M21.5417 15.5832H20.1667V5.49985C20.1667 4.48875 19.3444 3.6665 18.3333 3.6665H3.66665C2.65555 3.6665 1.8333 4.48871 1.8333 5.49985V15.5832H0.458305C0.205004 15.5832 0 15.7882 0 16.0415V16.4999C0 17.5109 0.822207 18.3332 1.83335 18.3332H20.1667C21.1778 18.3332 22 17.5109 22 16.4999V16.0415C22 15.7882 21.795 15.5832 21.5417 15.5832Z" fill="#303C42" />
                                        <path d="M2.75 5.49966C2.75 4.99435 3.16134 4.58301 3.66665 4.58301H18.3333C18.8386 4.58301 19.25 4.99435 19.25 5.49966V15.583H13.2917H8.70835H2.75V5.49966Z" fill="#5C6671" />
                                        <path d="M2.75 5.49966C2.75 4.99435 3.16134 4.58301 3.66665 4.58301H18.3333C18.8386 4.58301 19.25 4.99435 19.25 5.49966V15.583H13.2917H8.70835H2.75V5.49966Z" fill="url(#paint0_linear_12631_94694)" />
                                        <path d="M2.75 5.49966C2.75 4.99435 3.16134 4.58301 3.66665 4.58301H18.3333C18.8386 4.58301 19.25 4.99435 19.25 5.49966V15.583H13.2917H8.70835H2.75V5.49966Z" fill="url(#paint1_linear_12631_94694)" />
                                        <path d="M20.1665 17.4167H1.83316C1.32784 17.4167 0.916504 17.0053 0.916504 16.5H2.2915H8.51836L8.84243 16.8241C8.92837 16.91 9.04473 16.9583 9.1665 16.9583H12.8332C12.9549 16.9583 13.0713 16.91 13.1572 16.8241L13.4813 16.5H19.7082H21.0832C21.0832 17.0053 20.6718 17.4167 20.1665 17.4167Z" fill="#546E7A" />
                                        <path d="M2.75 10.0835V8.25015L6.41665 4.5835H8.25L2.75 10.0835Z" fill="url(#paint2_linear_12631_94694)" />
                                        <path d="M2.75 12.3751L10.5417 4.5835H11.9167L2.75 13.7501V12.3751Z" fill="url(#paint3_linear_12631_94694)" />
                                        <path d="M21.5417 15.5832H20.1667V5.49985C20.1667 4.48875 19.3444 3.6665 18.3333 3.6665H3.66665C2.65555 3.6665 1.8333 4.48871 1.8333 5.49985V15.5832H0.458305C0.205004 15.5832 0 15.7882 0 16.0415V16.4999C0 17.5109 0.822207 18.3332 1.83335 18.3332H20.1667C21.1778 18.3332 22 17.5109 22 16.4999V16.0415C22 15.7882 21.795 15.5832 21.5417 15.5832Z" fill="url(#paint4_linear_12631_94694)" />
                                    </g>
                                    <defs>
                                        <linearGradient id="paint0_linear_12631_94694" x1="2.32659" y1="6.20558" x2="19.8194" y2="14.3631" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" stop-opacity="0.2" />
                                            <stop offset="1" stop-color="white" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear_12631_94694" x1="6.70192" y1="17.8652" x2="15.4212" y2="2.76121" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" stop-opacity="0.2" />
                                            <stop offset="1" stop-color="white" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint2_linear_12631_94694" x1="3.59195" y1="6.44495" x2="6.70614" y2="7.89658" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" stop-opacity="0.07" />
                                            <stop offset="1" stop-color="white" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint3_linear_12631_94694" x1="4.79572" y1="7.9854" x2="9.34467" y2="10.1048" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" stop-opacity="0.07" />
                                            <stop offset="1" stop-color="white" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint4_linear_12631_94694" x1="1.04454" y1="6.78657" x2="22.1343" y2="16.6193" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" stop-opacity="0.2" />
                                            <stop offset="1" stop-color="white" stop-opacity="0" />
                                        </linearGradient>
                                        <clipPath id="clip0_12631_94694">
                                            <rect width="22" height="22" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-black mb-1">Full-Time Employment</h3>
                            <p class="text-base font-medium text-muted">I'm looking for a steady <br /> 9-to-5 job.</p>
                        </div>
                    </div>

                    <button id="submit-btn" type="submit" disabled class="w-full bg-gradient-to-r from-[#68A3FF] to-primary text-white font-semibold py-3 px-4 mt-5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                        Create Account
                    </button>
                </form>

                <p class="text-center text-muted mt-6">
                    Already have an account? <a href="#" class="font-semibold text-primary hover:underline">Login</a>
                </p>

            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const clientCard = document.getElementById('client-card');
            const employmentCard = document.getElementById('employment-card');
            const signupForm = document.getElementById('signup-form');
            const submitButton = document.getElementById('submit-btn');

            let selectedAccount = null;

            const selectedClasses = ['border-indigo-500', 'bg-indigo-50', 'shadow-lg', 'scale-105'];
            const unselectedClasses = ['border-gray-200', 'bg-white', 'hover:border-gray-300', 'hover:shadow-md'];

            const updateSelection = (selection) => {
                selectedAccount = selection;

                if (selection === 'client') {
                    clientCard.classList.remove(...unselectedClasses);
                    clientCard.classList.add(...selectedClasses);
                    clientCard.setAttribute('aria-pressed', 'true');

                    employmentCard.classList.remove(...selectedClasses);
                    employmentCard.classList.add(...unselectedClasses);
                    employmentCard.setAttribute('aria-pressed', 'false');
                } else if (selection === 'employment') {
                    employmentCard.classList.remove(...unselectedClasses);
                    employmentCard.classList.add(...selectedClasses);
                    employmentCard.setAttribute('aria-pressed', 'true');

                    clientCard.classList.remove(...selectedClasses);
                    clientCard.classList.add(...unselectedClasses);
                    clientCard.setAttribute('aria-pressed', 'false');
                }

                submitButton.disabled = !selectedAccount;
            };

            clientCard.addEventListener('click', () => {
                updateSelection('client');
            });

            employmentCard.addEventListener('click', () => {
                updateSelection('employment');
            });

            signupForm.addEventListener('submit', (event) => {
                event.preventDefault();
                if (selectedAccount == 'client') {
                    window.location.href = '/client/setup'
                    // alert(`Creating account as: ${selectedAccount}`);
                    // In a real application, you would make an API call here.
                }

                return window.location.href = '/candidate/setup'
            });
        });
    </script>
    @endpush

</x-layouts.app>