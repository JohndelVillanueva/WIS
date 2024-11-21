<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Nurse Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.10.2/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div 
        x-data="nursedashboard()" 
        class="w-full max-w-md p-8 space-y-6 bg-white shadow-2xl rounded-xl"
    >
        <div class="text-center">
            <h1 class="text-3xl font-bold text-green-600 mb-4">
                Student Health Check-In
            </h1>
            <p class="text-gray-500 mb-6">
                Secure and efficient student tracking
            </p>
        </div>

        <div class="space-y-4">
            <div class="relative">
                <input 
                    x-model="studentId" 
                    @keyup.enter="checkIn"
                    type="text" 
                    placeholder="Enter Student ID" 
                    class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-300"
                >
                <div 
                    x-show="studentId.length > 0" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                >
                    <svg 
                        x-show="studentIdValid" 
                        class="h-5 w-5 text-green-500" 
                        fill="currentColor" 
                        viewBox="0 0 20 20"
                    >
                        <path 
                            fill-rule="evenodd" 
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" 
                            clip-rule="evenodd" 
                        />
                    </svg>
                </div>
            </div>

            <button 
                @click="checkIn" 
                :disabled="!studentIdValid"
                class="w-full py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-300 disabled:opacity-50"
            >
                Check In Student
            </button>
        </div>

        <div 
            x-show="checkInStatus" 
            x-transition 
            class="mt-4 p-4 rounded-lg text-center"
            :class="checkInSuccess ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
        >
            <p x-text="checkInStatus"></p>
        </div>

        <div class="text-center text-gray-400 text-sm mt-4">
            Powered by Secure Health Systems
        </div>
    </div>

    <script>
        function nurseDatabase() {
            // Simulated database of valid student IDs
            const validStudents = [
                '12345', '67890', '54321', 
                'NURSE2023', 'ADMIN123'
            ];
            
            return {
                validateStudentId(id) {
                    return validStudents.includes(id);
                },
                recordCheckIn(id) {
                    // Simulate backend API call
                    return new Promise((resolve) => {
                        setTimeout(() => {
                            resolve({
                                success: true,
                                message: `Student ${id} checked in successfully at ${new Date().toLocaleTimeString()}`
                            });
                        }, 500);
                    });
                }
            };
        }

        function nursedashboard() {
            const db = nurseDatabase();

            return {
                studentId: '',
                checkInStatus: '',
                checkInSuccess: false,
                
                get studentIdValid() {
                    return this.studentId.length > 2;
                },

                async checkIn() {
                    if (!this.studentIdValid) {
                        this.checkInStatus = 'Please enter a valid student ID';
                        this.checkInSuccess = false;
                        return;
                    }

                    if (!db.validateStudentId(this.studentId)) {
                        this.checkInStatus = 'Unknown student ID. Please verify.';
                        this.checkInSuccess = false;
                        return;
                    }

                    try {
                        const result = await db.recordCheckIn(this.studentId);
                        this.checkInStatus = result.message;
                        this.checkInSuccess = result.success;
                    } catch (error) {
                        this.checkInStatus = 'Check-in failed. Please try again.';
                        this.checkInSuccess = false;
                    }
                }
            };
        }
    </script>
</body>
</html>