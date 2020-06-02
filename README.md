# Ecommerce Utilizando Laravel

Ecommerce utilizando a linguagem Laravel e banco de dados Mysql

Funcionalidades:
Usuario: Logar,Registrar,Colocar Itens no carrinho.Ver seus Pedidos,Finalizar Compra, Podendo ser pago em paypal ou dinheiro.
Admin:Gerenciar Pedidos,Produtos,Usuarios
Metodos De Pagamento: Integracao Com Paypal

Bibliotecas Utilizadas:
Para O Controle Do Carrinho: https://github.com/darryldecode/laravelshoppingcart
Para O Admin poder gerenciar Produtos etc: https://github.com/the-control-group/voyager
Api de Integracao do Paypal: https://github.com/paypal/PayPal-PHP-SDK

Instalação:

1: Dar um git clone no projeto

2: Rodar composer install ou composer update

3: Renomear o env.exempla para .env e configurar seus dados da api do paypal e do banco de dados

4: Rodar as Migrations

5: Opcional: Roda seed de produtos, porem ira sem imagem, mas podendo ser alterado no tcg voyager futuramente

6: Rodar o comando do tcg voyager php artisan voyager:install --with-dummy

7: Rodar o comando para dar permissao de admin ao usuario que ja deve ter sido cadastrado antes php artisan voyager:admin seu@email.com

8: Opcional: Rodar o comando php artisan voyager:admin seu@email.com --create aonde ele ira criar um usuario admin e ira pedir para você
falar um nome de usuario e senha

9: Configuracao do TCG VOYAGER

VIDEO:
