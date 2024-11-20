// Função para cadastrar uma nova aeronave
document.getElementById('formCadastrarAeronave').addEventListener('submit', function(event) {
    event.preventDefault();

    const modelo = document.getElementById('modelo').value;
    const fabricante = document.getElementById('fabricante').value;
    const ano_fabricacao = document.getElementById('ano_fabricacao').value;
    const matricula = document.getElementById('matricula').value;

    const data = {
        modelo,
        fabricante,
        ano_fabricacao,
        matricula
    };

    fetch('http://localhost:8000/aeronaves', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Aeronave cadastrada com sucesso:', data);
        alert('Aeronave cadastrada com sucesso!');
        listarAeronaves(); // Atualiza a lista de aeronaves após cadastro
    })
    .catch(error => {
        console.error('Erro ao cadastrar aeronave:', error);
        alert('Erro ao cadastrar aeronave.');
    });
});

// Função para listar todas as aeronaves
function listarAeronaves() {
    fetch('http://localhost:8000/aeronaves')
    .then(response => response.json())
    .then(data => {
        const aeronavesList = document.getElementById('aeronavesList');
        aeronavesList.innerHTML = ''; // Limpa a lista atual

        if (data.message) {
            aeronavesList.innerHTML = `<p>${data.message}</p>`;
        } else {
            data.forEach(aeronave => {
                const div = document.createElement('div');
                div.classList.add('aeronave');
                div.innerHTML = `
                    <p>ID: ${aeronave.id}</p>
                    <p>Modelo: ${aeronave.modelo}</p>
                    <p>Fabricante: ${aeronave.fabricante}</p>
                    <p>Ano de Fabricação: ${aeronave.ano_fabricacao}</p>
                    <p>Matrícula: ${aeronave.matricula}</p>
                    <hr>
                `;
                aeronavesList.appendChild(div);
            });
        }
    })
    .catch(error => {
        console.error('Erro ao listar aeronaves:', error);
        alert('Erro ao listar aeronaves.');
    });
}

// Função para atualizar a aeronave
document.getElementById('formAtualizarAeronave').addEventListener('submit', function(event) {
    event.preventDefault();

    const id = document.getElementById('id').value; // ID da aeronave que será atualizada
    const modelo = document.getElementById('modelo').value;
    const fabricante = document.getElementById('fabricante').value;
    const ano_fabricacao = document.getElementById('ano_fabricacao').value;
    const matricula = document.getElementById('matricula').value;

    const data = {
        modelo,
        fabricante,
        ano_fabricacao,
        matricula
    };

    fetch(`http://localhost:8000/aeronaves/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Aeronave atualizada com sucesso:', data);
        alert('Aeronave atualizada com sucesso!');
        listarAeronaves(); // Atualiza a lista de aeronaves após atualização
    })
    .catch(error => {
        console.error('Erro ao atualizar aeronave:', error);
        alert('Erro ao atualizar aeronave.');
    });
});


// Função para remover uma aeronave
document.getElementById('formRemoverAeronave').addEventListener('submit', function(event) {
    event.preventDefault();

    const id = document.getElementById('removerId').value;  // Alterando para 'removerId'

    fetch(`http://localhost:8000/aeronaves/${id}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        console.log('Aeronave removida com sucesso:', data);
        alert('Aeronave removida com sucesso!');
        listarAeronaves(); // Atualiza a lista de aeronaves após remoção
    })
    .catch(error => {
        console.error('Erro ao remover aeronave:', error);
        alert('Erro ao remover aeronave.');
    });
});

document.getElementById('formCadastrarOrdemServico').addEventListener('submit', function (e) {
    e.preventDefault();

    const descricao = document.getElementById('descricao').value;
    const status = document.getElementById('status').value;
    const aeronave_id = document.getElementById('aeronave_id').value;

    // Verifique se os campos estão preenchidos
    if (!descricao || !status || !aeronave_id) {
        alert('Por favor, preencha todos os campos.');
        return;
    }

    // Enviar os dados via fetch
    fetch('/api/ordemServico/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            descricao: descricao,
            status: status,
            aeronave_id: aeronave_id
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erro ao cadastrar ordem de serviço:', error);
    });
});



// Função para listar todas as ordens de serviço
function listarOrdensServico() {
    fetch('http://localhost:8000/api/ordemServico')
    .then(response => response.json())
    .then(data => {
        console.log('Dados recebidos:', data);  // Adicionando log para depuração
        const ordensServicoList = document.getElementById('ordensServicoList');
        ordensServicoList.innerHTML = ''; // Limpa a lista atual

        if (data.message) {
            ordensServicoList.innerHTML = `<p>${data.message}</p>`;
        } else {
            data.forEach(ordem => {
                const div = document.createElement('div');
                div.classList.add('ordemServico');
                div.innerHTML = `
                    <p>ID: ${ordem.id}</p>
                    <p>Descrição: ${ordem.descricao}</p>
                    <p>Status: ${ordem.status}</p>
                    <p>Aeronave ID: ${ordem.aeronave_id}</p>
                    <hr>
                `;
                ordensServicoList.appendChild(div);
            });
        }
    })
    .catch(error => {
        console.error('Erro ao listar ordens de serviço:', error);
        alert('Erro ao listar ordens de serviço.');
    });
}


// Função para deletar uma ordem de serviço
document.getElementById('formDeletarOrdemServico').addEventListener('submit', function(event) {
    event.preventDefault();

    // Captura o valor do campo de ID
    const id = document.getElementById('id').value;
    console.log("ID capturado: ", id);  // Para depuração, veja se o valor está sendo capturado

    // Verifica se o ID foi fornecido
    if (!id) {
        alert("ID não fornecido.");
        return;  // Impede o envio da requisição se o ID não for fornecido
    }

    // Realiza a requisição DELETE com o ID
    fetch(`http://localhost:8000/ordens-servico/${id}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        console.log('Ordem de serviço deletada com sucesso:', data);
        alert('Ordem de serviço deletada com sucesso!');
        listarOrdensServico(); // Atualiza a lista de ordens de serviço após remoção
    })
    .catch(error => {
        console.error('Erro ao deletar ordem de serviço:', error);
        alert('Erro ao deletar ordem de serviço.');
    });
});



