<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Gerenciamento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.6s ease-out; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float { animation: float 3s ease-in-out infinite; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-6xl mx-auto grid md:grid-cols-2 gap-8 items-center">
        <!-- Lado Esquerdo - Ilustração/Branding -->
        <div class="hidden md:flex flex-col items-center justify-center text-center space-y-6 animate-fadeIn">
            <div class="animate-float">
                <img 
                    src="{{ asset('imagens/hand-drawn-vintage-bread-and-basket-logo-in-flat-style-png.png') }}" 
                    alt="Logo" 
                    class="w-48 h-48 drop-shadow-2xl"
                >
            </div>
            <div class="space-y-3">
                <h1 class="text-4xl font-bold text-gray-800">Sistema de Gerenciamento</h1>
                <p class="text-xl text-gray-600">Controle total do seu negócio</p>
                <div class="flex items-center justify-center gap-6 mt-6 text-gray-700">
                    <div class="flex flex-col items-center">
                        <i class="bi bi-cart-check text-4xl text-blue-600 mb-2"></i>
                        <span class="text-sm font-medium">Vendas</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <i class="bi bi-box-seam text-4xl text-green-600 mb-2"></i>
                        <span class="text-sm font-medium">Estoque</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <i class="bi bi-graph-up text-4xl text-purple-600 mb-2"></i>
                        <span class="text-sm font-medium">Relatórios</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lado Direito - Formulário de Login -->
        <div class="animate-fadeIn">
            <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-10 border border-gray-100">
                <!-- Logo Mobile -->
                <div class="md:hidden flex justify-center mb-6">
                    <img 
                        src="{{ asset('imagens/hand-drawn-vintage-bread-and-basket-logo-in-flat-style-png.png') }}" 
                        alt="Logo" 
                        class="w-20 h-20"
                    >
                </div>

                <!-- Cabeçalho -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Bem-vindo de volta!</h2>
                    <p class="text-gray-600">Entre com suas credenciais para continuar</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

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

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-envelope mr-2 text-blue-600"></i>E-mail
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="seu@email.com"
                        >
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-lock mr-2 text-blue-600"></i>Senha
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="••••••••"
                        >
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input 
                                id="remember_me" 
                                type="checkbox" 
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring-2" 
                                name="remember"
                            >
                            <span class="ml-2 text-sm text-gray-700">Lembrar-me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors" href="{{ route('password.request') }}">
                                Esqueceu a senha?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transform hover:scale-[1.02] transition-all shadow-lg hover:shadow-xl"
                    >
                        <i class="bi bi-box-arrow-in-right mr-2"></i>Entrar
                    </button>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500">Ou</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Não tem uma conta? 
                            <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                                Cadastre-se agora
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6 text-sm text-gray-600">
                <p>&copy; {{ date('Y') }} Sistema de Gerenciamento. Todos os direitos reservados.</p>
            </div>
        </div>
    </div>
</body>
</html>
