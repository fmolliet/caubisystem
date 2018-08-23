<div class="interface">
    <h3>Menu de cadastro de cliente:</h3>
    <form name="form1" method="POST" action="" onsubmit="confirm()">
        <label>Primeiro Nome: </label><input type="text" name="fname" id="fname" required> <label>Segundo Nome: </label><input type="text" name="sname" id="sname" required><br/><br/>
        <label>CPF: </label><input type="text" name="cpf" id="cpf" required> <label>Email: </label><input type="email" name="email" id="email"size="35" required><br /><br />
        <label>Nome do negócio: </label> <spam class='obs'>(opcional)</spam> <input type="text" name="business" id="business"> <br/><br/>
        <label>Endereço: </label><input type="text" name="end" id="end" required> <label>Complemento: </label><spam class='obs'>(opcional)</spam> <input type="text" name="complement" id="complement"><br/><br/>
        <label id="campo_cidade">Cidade: </label><input type="text" name="city" id="city" required><label id="campo_estado"> UF: </label><input type="text" name="state" id="state" maxlength="2"size="4" required> <label id="campo_pais">País: </label><input type="text" name="country" id="country" required><br/><br/>
        <input type="hidden" name="cmd" id="cmd" value="insert">
        <input type="submit" name="cmd2" value="Cadastrar!" id="cmd2" align="center">
    </form>
</div>