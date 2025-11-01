<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Sistema de Gerenciamento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.6s ease-out; }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 via-teal-50 to-blue-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto animate-fadeIn">
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-10 border border-gray-100">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <div class="bg-gradient-to-br from-green-100 to-teal-100 rounded-full p-4">
                    <i class="bi bi-key text-5xl text-green-600"></i>
                </div>
            </div>

            <!-- Cabeçalho -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Esqueceu a senha?</h2>
                <p class="text-gray-600">Sem problemas! Informe seu e-mail e enviaremos um link para redefinir sua senha.</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="bi bi-check-circle-fill text-green-500 text-xl mr-3"></i>
                        <p class="text-green-800 font-medium">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i class="bi bi-exclamation-circle-fill text-red-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-red-800 font-medium">Ops! Algo deu errado:</p>
                            <ul class="text-sm text-red-700 mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-envelope mr-2 text-green-600"></i>E-mail
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                        placeholder="seu@email.com"
                    >
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-green-600 to-teal-600 text-white py-3 rounded-lg font-semibold hover:from-green-700 hover:to-teal-700 transform hover:scale-[1.02] transition-all shadow-lg hover:shadow-xl"
                >
                    <i class="bi bi-envelope-paper mr-2"></i>Enviar Link de Recuperação
                </button>

                <!-- Back to Login -->
                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-800 transition-colors">
                        <i class="bi bi-arrow-left mr-2"></i>
                        Voltar para o login
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-gray-200">
            <div class="flex items-start gap-3">
                <i class="bi bi-info-circle text-blue-600 text-xl mt-1"></i>
                <div class="text-sm text-gray-700">
                    <p class="font-medium mb-1">Como funciona?</p>
                    <p>Após enviar o formulário, você receberá um e-mail com um link seguro para criar uma nova senha. O link expira em 60 minutos.</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-gray-600">
            <p>&copy; {{ date('Y') }} Sistema de Gerenciamento. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
