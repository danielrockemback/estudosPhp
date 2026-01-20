<!--

                    2-  Form
Formulários HTML são usados para coletar dados do usuário (login, cadastro, pesquisa, etc.).
No PHP, os dados enviados pelo formulário podem ser acessados via $_POST ou $_GET

-->

<form action="funcionalidade-web.php" method="post">
    Usuário: <input type="text" name="usuario"><br>
    Senha:   <input style="margin-left: 11px;" type="password" name="senha"><br>

    <button style="margin-left: 183px;" type="submit">Entrar</button>
</form>

<hr>

<h3>Tipos de inputs</h3>
<form action="#" method="post">
    <!-- Texto simples -->
    Nome: <input type="text" name="nome"><br>

    <!-- Email -->
    Email: <input type="email" name="email"><br>

    <!-- Senha -->
    Senha: <input type="password" name="senha"><br>

    <!-- Radio (escolha única) -->
    Sexo:
    <input type="radio" name="sexo" value="M"> Masculino
    <input type="radio" name="sexo" value="F"> Feminino<br>

    <!-- Checkbox (múltiplas escolhas) -->
    Interesses:
    <input type="checkbox" name="interesses[]" value="PHP"> PHP
    <input type="checkbox" name="interesses[]" value="JavaScript"> SQL Server
    <input type="checkbox" name="interesses[]" value="Python"> Vue JS<br>

    <!-- Select (lista) -->
    País:
    <select name="pais">
        <option value="br">Brasil</option>
        <option value="us">Estados Unidos</option>
        <option value="pt">Portugal</option>
    </select><br>

    <!-- Upload de arquivo -->
    Foto: <input type="file" name="foto"><br>

    <button type="submit">Enviar</button>
</form>
