<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Sistema de Gerenciamento</title>
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
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slideInRight { animation: slideInRight 0.6s ease-out; }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 min-h-screen flex items-center justify-center p-4">
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
            <div class="space-y-4">
                <h1 class="text-4xl font-bold text-gray-800">Junte-se a Nós!</h1>
                <p class="text-xl text-gray-600">Crie sua conta e comece a gerenciar seu negócio</p>
                
                <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 mt-8 space-y-4 max-w-md">
                    <div class="flex items-start gap-3">
                        <div class="bg-green-100 rounded-full p-2 mt-1">
                            <i class="bi bi-check-lg text-green-600 text-xl"></i>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold text-gray-800">Controle Total</h3>
                            <p class="text-sm text-gray-600">Gerencie vendas, estoque e fornecedores em um só lugar</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="bg-blue-100 rounded-full p-2 mt-1">
                            <i class="bi bi-graph-up text-blue-600 text-xl"></i>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold text-gray-800">Relatórios Detalhados</h3>
                            <p class="text-sm text-gray-600">Acompanhe o desempenho com gráficos e dados</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="bg-purple-100 rounded-full p-2 mt-1">
                            <i class="bi bi-shield-check text-purple-600 text-xl"></i>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold text-gray-800">Seguro e Confiável</h3>
                            <p class="text-sm text-gray-600">Seus dados protegidos com a melhor tecnologia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lado Direito - Formulário de Cadastro -->
        <div class="animate-slideInRight">
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
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Criar Conta</h2>
                    <p class="text-gray-600">Preencha seus dados para começar</p>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                        <div class="flex items-center">
                            <i class="bi bi-exclamation-circle-fill text-red-500 text-xl mr-3"></i>
                            <div>
                                <p class="text-red-800 font-medium">Por favor, corrija os erros:</p>
                                <ul class="text-sm text-red-700 mt-1 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-person mr-2 text-purple-600"></i>Nome Completo
                        </label>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            placeholder="João da Silva"
                        >
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-envelope mr-2 text-purple-600"></i>E-mail
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            placeholder="seu@email.com"
                        >
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-lock mr-2 text-purple-600"></i>Senha
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            placeholder="Mínimo 8 caracteres"
                        >
                        <p class="text-xs text-gray-500 mt-1">Deve conter pelo menos 8 caracteres</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-lock-fill mr-2 text-purple-600"></i>Confirmar Senha
                        </label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                            placeholder="Digite a senha novamente"
                        >
                    </div>

                    <!-- Terms Acceptance (optional) -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input 
                                id="terms" 
                                type="checkbox" 
                                required
                                class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500 focus:ring-2"
                            >
                        </div>
                        <label for="terms" class="ml-2 text-sm text-gray-700">
                            Eu concordo com os 
                            <a href="#" class="text-purple-600 hover:text-purple-800 font-medium">Termos de Uso</a> 
                            e 
                            <a href="#" class="text-purple-600 hover:text-purple-800 font-medium">Política de Privacidade</a>
                        </label>
                    </div>

                    <!-- Register Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transform hover:scale-[1.02] transition-all shadow-lg hover:shadow-xl"
                    >
                        <i class="bi bi-person-plus mr-2"></i>Criar Conta
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

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Já tem uma conta? 
                            <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-800 font-semibold transition-colors">
                                Faça login
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
