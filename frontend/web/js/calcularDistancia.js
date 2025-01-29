function calcularDistancia() {
    // Impede o envio normal do formulário (sem recarregar a página)
    event.preventDefault();

    // Pega o valor da morada inserida
    var endereco = document.getElementById("endereco").value;

    // Verifica se o endereço foi preenchido
    if (endereco.trim() === "") {
        alert("Por favor, insira a sua morada.");
        return false;
    }

    // Cria o formulário e faz o envio da morada para o servidor
    var formData = new FormData();
    formData.append("endereco", endereco);

    // Criação de uma requisição para o backend (sem usar AJAX)
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "<?= \yii\helpers\Url::to(['carrinho-compras/calcular-distancia']) ?>", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Define a função que vai ser executada quando a requisição terminar
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Aqui, o backend deve retornar o valor total atualizado, por exemplo
            var resposta = JSON.parse(xhr.responseText);

            // Atualiza o valor do carrinho com a nova entrega
            document.querySelector('.valorTotal').textContent = resposta.novoTotal + "€";

            // Você pode também exibir alguma mensagem de sucesso
            alert('Distância calculada com sucesso. O valor total foi atualizado.');
        } else {
            alert('Erro ao calcular a distância.');
        }
    };

    // Envia os dados do formulário para o servidor
    xhr.send("endereco=" + encodeURIComponent(endereco));

    return false;
}