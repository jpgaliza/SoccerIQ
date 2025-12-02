# ⚽ Web Quiz - Quiz de Futebol

Um site interativo de quiz sobre futebol desenvolvido com Laravel e Vue.js usando Inertia.js.

## 🚀 Como executar localmente

### Pré-requisitos

-   PHP 8.2 ou superior
-   Composer
-   Node.js 18+ e npm
-   MySQL ou outro banco de dados compatível

### Passo a passo

1. **Clone o repositório e entre na pasta**

    ```bash
    git clone <url-do-repositorio>
    cd web-quiz
    ```

2. **Instale as dependências do PHP**

    ```bash
    composer install
    ```

3. **Instale as dependências do Node.js**

    ```bash
    npm install -f
    ```

4. **Configure o arquivo de ambiente**

    ```bash
    cp .env.example .env
    ```

    Edite o arquivo `.env` com suas configurações de banco de dados.

5. **Gere a chave da aplicação**

    ```bash
    php artisan key:generate
    ```

6. **Execute as migrações do banco de dados**

    ```bash
    php artisan migrate
    ```

7. **Execute os seeders (opcional)**

    ```bash
    php artisan db:seed
    ```

8. **Inicie o servidor de desenvolvimento**

    Em um terminal:

    ```bash
    php artisan serve
    ```

    Em outro terminal:

    ```bash
    npm run dev
    ```

9. **Acesse a aplicação**

    Abra seu navegador e vá para: `http://localhost:8000`

## 🛠️ Tecnologias utilizadas

-   **Backend**: Laravel 12
-   **Frontend**: Vue.js 3 + Inertia.js
-   **Styling**: Tailwind CSS
-   **Build**: Vite

## 📝 Scripts disponíveis

-   `npm run dev` - Inicia o servidor de desenvolvimento do Vite
-   `npm run build` - Gera os arquivos de produção
-   `php artisan serve` - Inicia o servidor Laravel
-   `php artisan test` - Executa os testes

---

Divirta-se testando seus conhecimentos sobre futebol! ⚽
