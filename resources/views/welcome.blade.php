<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Gerenciador De Estoque</title>
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        
            /* Estilos adicionais para a página inicial */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Nunito', sans-serif;
            }

            body {
                background-color: #f8fafc;
                color: #334155;
                line-height: 1.6;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 20px;
            }

            /* Header */
            header {
                background: linear-gradient(135deg, #2563eb, #1e40af);
                color: white;
                padding: 15px 0;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                position: sticky;
                top: 0;
                z-index: 100;
            }

            .header-content {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .logo {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 24px;
                font-weight: bold;
            }

            .logo i {
                font-size: 28px;
            }

            nav ul {
                display: flex;
                list-style: none;
                gap: 25px;
            }

            nav ul li a {
                color: white;
                text-decoration: none;
                font-weight: 500;
                padding: 8px 16px;
                border-radius: 4px;
                transition: background-color 0.3s;
            }

            nav ul li a:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }

            /* Hero Section */
            .hero {
                background: linear-gradient(rgba(37, 99, 235, 0.9), rgba(30, 64, 175, 0.9)), url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
                background-size: cover;
                background-position: center;
                color: white;
                text-align: center;
                padding: 100px 20px;
                margin-bottom: 60px;
            }

            .hero-content {
                max-width: 800px;
                margin: 0 auto;
            }

            .hero h1 {
                font-size: 48px;
                margin-bottom: 20px;
                line-height: 1.2;
            }

            .hero p {
                font-size: 20px;
                margin-bottom: 30px;
                opacity: 0.9;
            }

            .btn {
                display: inline-block;
                background-color: white;
                color: #2563eb;
                padding: 14px 30px;
                border-radius: 50px;
                text-decoration: none;
                font-weight: bold;
                font-size: 18px;
                transition: transform 0.3s, box-shadow 0.3s;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            }

            /* Section Styling */
            section {
                padding: 60px 0;
            }

            .section-title {
                text-align: center;
                margin-bottom: 50px;
            }

            .section-title h2 {
                font-size: 36px;
                color: #1e293b;
                margin-bottom: 15px;
            }

            .section-title p {
                font-size: 18px;
                color: #64748b;
                max-width: 700px;
                margin: 0 auto;
            }

            /* About System */
            .about-content {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 40px;
                align-items: center;
            }

            .about-text h3 {
                font-size: 28px;
                margin-bottom: 20px;
                color: #1e293b;
            }

            .about-text p {
                margin-bottom: 20px;
                font-size: 17px;
            }

            .about-image img {
                width: 100%;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            /* Features */
            .features {
                background-color: #f1f5f9;
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 30px;
            }

            .feature-card {
                background-color: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
                text-align: center;
                transition: transform 0.3s;
            }

            .feature-card:hover {
                transform: translateY(-5px);
            }

            .feature-icon {
                font-size: 40px;
                color: #2563eb;
                margin-bottom: 20px;
            }

            .feature-card h3 {
                font-size: 22px;
                margin-bottom: 15px;
                color: #1e293b;
            }

            /* Benefits */
            .benefits-list {
                max-width: 800px;
                margin: 0 auto;
            }

            .benefit-item {
                display: flex;
                align-items: flex-start;
                gap: 20px;
                margin-bottom: 30px;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            }

            .benefit-icon {
                font-size: 24px;
                color: #2563eb;
                background-color: #dbeafe;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .benefit-content h3 {
                font-size: 20px;
                margin-bottom: 10px;
                color: #1e293b;
            }

            /* CTA Section */
            .cta {
                background: linear-gradient(135deg, #2563eb, #1e40af);
                color: white;
                text-align: center;
                padding: 80px 20px;
                border-radius: 10px;
                margin: 60px 0;
            }

            .cta h2 {
                font-size: 36px;
                margin-bottom: 20px;
            }

            .cta p {
                font-size: 18px;
                margin-bottom: 30px;
                max-width: 700px;
                margin-left: auto;
                margin-right: auto;
            }

            .btn-light {
                background-color: transparent;
                color: white;
                border: 2px solid white;
            }

            .btn-light:hover {
                background-color: white;
                color: #2563eb;
            }

            /* Footer */
            footer {
                background-color: #1e293b;
                color: white;
                padding: 60px 0 30px;
            }

            .footer-content {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 40px;
                margin-bottom: 40px;
            }

            .footer-column h3 {
                font-size: 20px;
                margin-bottom: 20px;
                color: #e2e8f0;
            }

            .footer-column p, .footer-column a {
                color: #94a3b8;
                margin-bottom: 10px;
                display: block;
                text-decoration: none;
                transition: color 0.3s;
            }

            .footer-column a:hover {
                color: white;
            }

            .social-links {
                display: flex;
                gap: 15px;
                margin-top: 15px;
            }

            .social-links a {
                font-size: 20px;
            }

            .copyright {
                text-align: center;
                padding-top: 30px;
                border-top: 1px solid #334155;
                color: #94a3b8;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .header-content {
                    flex-direction: column;
                    gap: 15px;
                }

                nav ul {
                    gap: 15px;
                }

                .hero h1 {
                    font-size: 36px;
                }

                .hero p {
                    font-size: 18px;
                }

                .about-content {
                    grid-template-columns: 1fr;
                }

                .section-title h2 {
                    font-size: 30px;
                }
            }
        </style>
    </head>
    <body class="antialiased">
        <!-- Navigation from original code -->
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Registrar</a>
                    @endif
                @endauth
            @endif
        </div>

        <!-- Header -->
        <header>
            <div class="container">
                <div class="header-content">
                    <div class="logo">
                        <i class="fas fa-boxes"></i>
                        <span>Gerenciador De Estoque</span>
                    </div>
                    <nav>
                        <ul>
                            <li><a href="#">Início</a></li>
                            <li><a href="#">Recursos</a></li>
                            <li><a href="#">Benefícios</a></li>
                            <li><a href="#">Contato</a></li>
                            @auth
                                <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            @else
                                <li><a href="{{ route('login') }}">Login</a></li>
                                @if (Route::has('register'))
                                    <li><a href="{{ route('register') }}">Registrar</a></li>
                                @endif
                            @endauth
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1>Sistema de Gerenciamento de Estoque</h1>
                    <p>Controle completo do seu inventário com eficiência e precisão</p>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn">Acessar Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn">Começar Agora</a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- About System -->
        <section class="about">
            <div class="container">
                <div class="section-title">
                    <h2>O que é um Sistema de Gerenciamento de Estoque?</h2>
                    <p>Entenda como nossa solução pode transformar a gestão do seu negócio</p>
                </div>
                <div class="about-content">
                    <div class="about-text">
                        <h3>Controle total do seu inventário</h3>
                        <p>Um Sistema de Gerenciamento de Estoque é uma solução tecnológica que permite às empresas controlar, organizar e acompanhar todos os aspectos relacionados ao seu inventário de produtos.</p>
                        <p>Com nossa plataforma, você tem visibilidade completa sobre entradas, saídas, níveis de estoque, validade de produtos e muito mais, tudo em tempo real e de qualquer lugar.</p>
                        <p>O sistema ajuda a evitar excessos ou falta de produtos, otimiza o espaço de armazenamento e fornece dados valiosos para a tomada de decisões estratégicas.</p>
                    </div>
                    <div class="about-image">
                        <img src="https://images.unsplash.com/photo-1590650516494-0c8e4a4dd67b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Sistema de Gerenciamento de Estoque">
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="features">
            <div class="container">
                <div class="section-title">
                    <h2>Principais Funcionalidades</h2>
                    <p>Descubra tudo que nosso sistema pode fazer pelo seu negócio</p>
                </div>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h3>Controle de Produtos</h3>
                        <p>Cadastre e gerencie todos os seus produtos com informações detalhadas como código, descrição, categoria e localização.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <h3>Movimentações</h3>
                        <p>Registro completo de todas as entradas e saídas de produtos, com data, hora e responsável.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Relatórios</h3>
                        <p>Gere relatórios detalhados sobre giro de estoque, produtos mais vendidos e previsão de demanda.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h3>Alertas Automáticos</h3>
                        <p>Receba alertas quando os produtos estiverem com estoque baixo ou perto da data de validade.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-barcode"></i>
                        </div>
                        <h3>Controle por Código de Barras</h3>
                        <p>Use leitores de código de barras para agilizar as movimentações de estoque.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3>Acesso Mobile</h3>
                        <p>Acesse o sistema de qualquer lugar através de dispositivos móveis como tablets e smartphones.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits -->
        <section class="benefits">
            <div class="container">
                <div class="section-title">
                    <h2>Vantagens do Sistema</h2>
                    <p>Os benefícios de implementar um sistema de gerenciamento de estoque</p>
                </div>
                <div class="benefits-list">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="benefit-content">
                            <h3>Redução de Custos</h3>
                            <p>Evite excesso de estoque e minimize perdas por produtos obsoletos ou com prazo de validade vencido.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="benefit-content">
                            <h3>Economia de Tempo</h3>
                            <p>Automatize processos manuais e reduza o tempo gasto com contagem e organização de estoque.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="benefit-content">
                            <h3>Melhor Tomada de Decisão</h3>
                            <p>Tenha acesso a dados precisos e relatórios detalhados para tomar decisões estratégicas baseadas em informações reais.</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-smile"></i>
                        </div>
                        <div class="benefit-content">
                            <h3>Aumento da Satisfação do Cliente</h3>
                            <p>Nunca mais perca uma venda por falta de estoque e garanta entregas rápidas e eficientes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <div class="container">
            <div class="cta">
                <h2>Pronto para transformar sua gestão de estoque?</h2>
                <p>Experimente gratuitamente e descubra como nosso sistema pode impulsionar seu negócio</p>
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-light">Acessar Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-light">Criar Conta</a>
                @endauth
            </div>
        </div>

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="footer-content">
                    <div class="footer-column">
                        <h3>Gerenciador De Estoque</h3>
                        <p>Sistema de gerenciamento de estoque completo e intuitivo para empresas de todos os tamanhos.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    <div class="footer-column">
                        <h3>Recursos</h3>
                        <a href="#">Controle de Estoque</a>
                        <a href="#">Relatórios</a>
                        <a href="#">Alertas Automáticos</a>
                        <a href="#">Integrações</a>
                    </div>
                    <div class="footer-column">
                        <h3>Suporte</h3>
                        <a href="#">Central de Ajuda</a>
                        <a href="#">Tutoriais</a>
                        <a href="#">FAQ</a>
                        <a href="#">Contato</a>
                    </div>
                    <div class="footer-column">
                        <h3>Contato</h3>
                        <p><i class="fas fa-map-marker-alt"></i> Av. Paulista, 1000, São Paulo</p>
                        <p><i class="fas fa-phone"></i> (11) 9999-9999</p>
                        <p><i class="fas fa-envelope"></i> contato@gerenciadorestoque.com</p>
                    </div>
                </div>
                <div class="copyright">
                    <p>&copy; 2023 Gerenciador De Estoque - Todos os direitos reservados</p>
                </div>
            </div>
        </footer>
    </body>
</html>

<!-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gerenciador De Estoque</title>

         Fonts 
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

         Styles 
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="p-6 bg-white border-b border-gray-200" class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Registrar</a>
                        @endif
                    @endauth
                </div>
            @endif

        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="form-group">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html> -->
