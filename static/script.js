/*document.getElementById("formCadastrarAeronave")?.addEventListener("submit", function(event) {
    event.preventDefault();

    const modelo = document.getElementById("modelo").value;
    const fabricante = document.getElementById("fabricante").value;
    const ano_fabricacao = document.getElementById("ano_fabricacao").value;
    const matricula = document.getElementById("matricula").value;

    const dadosAeronave = {
        modelo,
        fabricante,
        ano_fabricacao,
        matricula
    };

    fetch('/salvar_aeronave', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosAeronave)
    })
    .then(response => response.json())
    .then(data => {
        alert("Aeronave cadastrada com sucesso!");
        document.getElementById("formCadastrarAeronave").reset();
    })
    .catch(error => {
        alert("Erro ao cadastrar a aeronave.");
        console.error(error);
    });
});

document.getElementById("formCadastrarOrdemServico")?.addEventListener("submit", function(event) {
    event.preventDefault();

    const descricao = document.getElementById("descricao").value;
    const status = document.getElementById("status").value;
    const aeronave_id = document.getElementById("aeronave_id").value;

    const dadosOrdem = {
        descricao,
        status,
        aeronave_id
    };

    fetch('/salvar_ordem', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosOrdem)
    })
    .then(response => response.json())
    .then(data => {
        alert("Ordem de Serviço cadastrada com sucesso!");
        document.getElementById("formCadastrarOrdemServico").reset();
    })
    .catch(error => {
        alert("Erro ao cadastrar a ordem de serviço.");
        console.error(error);
    });
});

document.getElementById("formRemoverAeronave")?.addEventListener("submit", function(event) {
    event.preventDefault();

    const id = document.getElementById("id").value;

    fetch(`/remover_aeronave/${id}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        alert("Aeronave removida com sucesso!");
        document.getElementById("formRemoverAeronave").reset();
    })
    .catch(error => {
        alert("Erro ao remover a aeronave.");
        console.error(error);
    });
});

document.getElementById("formAtualizarAeronave")?.addEventListener("submit", function(event) {
    event.preventDefault();

    const id = document.getElementById("id").value;
    const modelo = document.getElementById("modelo").value;
    const fabricante = document.getElementById("fabricante").value;
    const ano = document.getElementById("ano").value;
    const matricula = document.getElementById("matricula").value;

    const dadosAeronaveAtualizada = {
        modelo,
        fabricante,
        ano,
        matricula
    };

    fetch(`/atualizar_aeronave/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosAeronaveAtualizada)
    })
    .then(response => response.json())
    .then(data => {
        alert("Aeronave atualizada com sucesso!");
        document.getElementById("formAtualizarAeronave").reset();
    })
    .catch(error => {
        alert("Erro ao atualizar a aeronave.");
        console.error(error);
    });
});

document.getElementById("formDeletarOrdemServico")?.addEventListener("submit", function(event) {
    event.preventDefault();

    const id = document.getElementById("id").value;

    fetch(`/deletar_ordem_servico/${id}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(data => {
        alert("Ordem de serviço deletada com sucesso!");
        document.getElementById("formDeletarOrdemServico").reset();
    })
    .catch(error => {
        alert("Erro ao deletar a ordem de serviço.");
        console.error(error);
    });
});

*/

function getAeronaves() {
    const aeronaves = JSON.parse(localStorage.getItem("aeronaves")) || [];
    return aeronaves;
}

function saveAeronaves(aeronaves) {
    localStorage.setItem("aeronaves", JSON.stringify(aeronaves));
}

function listAeronaves() {
    const aeronaves = getAeronaves();
    const aeronavesList = document.getElementById("listaAeronaves");
    aeronavesList.innerHTML = '';

    aeronaves.forEach((aeronave, index) => {
        const li = document.createElement("li");
        li.textContent = `Modelo: ${aeronave.modelo}, Fabricante: ${aeronave.fabricante}, Ano: ${aeronave.ano_fabricacao}, Matrícula: ${aeronave.matricula}`;
        
        const removeButton = document.createElement("button");
        removeButton.textContent = "Remover";
        removeButton.onclick = function() {
            removeAeronave(index);
        };
        li.appendChild(removeButton);
        aeronavesList.appendChild(li);
    });
}

function removeAeronave(index) {
    const aeronaves = getAeronaves();
    aeronaves.splice(index, 1);
    saveAeronaves(aeronaves);
    listAeronaves();
}

document.getElementById("formCadastrarAeronave")?.addEventListener("submit", function(event) {
    event.preventDefault();

    const modelo = document.getElementById("modelo").value;
    const fabricante = document.getElementById("fabricante").value;
    const ano_fabricacao = document.getElementById("ano_fabricacao").value;
    const matricula = document.getElementById("matricula").value;

    const aeronave = { modelo, fabricante, ano_fabricacao, matricula };

    const aeronaves = getAeronaves();
    aeronaves.push(aeronave);
    saveAeronaves(aeronaves);

    alert("Aeronave cadastrada com sucesso!");
    document.getElementById("formCadastrarAeronave").reset();
    listAeronaves();
});

function getOrdensDeServico() {
    const ordens = JSON.parse(localStorage.getItem("ordens")) || [];
    return ordens;
}

function saveOrdensDeServico(ordens) {
    localStorage.setItem("ordens", JSON.stringify(ordens));
}

function listOrdensDeServico() {
    const ordens = getOrdensDeServico();
    const ordensList = document.getElementById("listaOrdensDeServico");
    ordensList.innerHTML = '';

    ordens.forEach((ordem, index) => {
        const li = document.createElement("li");
        li.textContent = `ID: ${ordem.id}, Aeronave: ${ordem.aeronave}, Status: ${ordem.status}, Data: ${ordem.data}`;

        const removeButton = document.createElement("button");
        removeButton.textContent = "Remover";
        removeButton.onclick = function() {
            removeOrdemDeServico(index);
        };
        li.appendChild(removeButton);
        ordensList.appendChild(li);
    });
}

function removeOrdemDeServico(index) {
    const ordens = getOrdensDeServico();
    ordens.splice(index, 1);
    saveOrdensDeServico(ordens);
    listOrdensDeServico();
}

document.getElementById("formCadastrarOrdemDeServico")?.addEventListener("submit", function(event) {
    event.preventDefault();

    const id = document.getElementById("id_origem").value;
    const aeronave = document.getElementById("aeronave_origem").value;
    const status = document.getElementById("status_origem").value;
    const data = document.getElementById("data_origem").value;

    const ordem = { id, aeronave, status, data };

    const ordens = getOrdensDeServico();
    ordens.push(ordem);
    saveOrdensDeServico(ordens);

    alert("Ordem de serviço cadastrada com sucesso!");
    document.getElementById("formCadastrarOrdemDeServico").reset();
    listOrdensDeServico();
});

window.onload = function() {
    listAeronaves();
    listOrdensDeServico();
};
