// Função para criar um novo campo de ingrediente
function criarCampoIngrediente(nomeIngrediente = '', quantidadeIngrediente = '', unidadeMedida = '') {
    const ingredienteContainer = document.querySelector('.ingredientes-container');
    const novoIngrediente = document.createElement('div');
    novoIngrediente.classList.add('ingrediente');

    novoIngrediente.innerHTML = `
        <input type="text" name="nome-ingrediente" placeholder="Nome do ingrediente" value="${nomeIngrediente}" required>
        <input type="number" name="quantidade-ingrediente" placeholder="Quantidade" value="${quantidadeIngrediente}" required>
        <select name="unidade-medida" required>
            <option value="">Selecione a unidade</option>
            <option value="gramas">gramas</option>
            <option value="mililitros">mililitros</option>
            <option value="colheres de sopa">colheres de sopa</option>
            <option value="colheres de chá">colheres de chá</option>
        </select>
        <button type="button" onclick="removerIngrediente(this)"><i class="fas fa-trash-alt"></i></button>
    `;

    ingredienteContainer.appendChild(novoIngrediente);
}

// Função para remover um campo de ingrediente
function removerIngrediente(botaoRemover) {
    const ingredienteContainer = document.querySelector('.ingredientes-container');
    ingredienteContainer.removeChild(botaoRemover.parentNode);
}

// Função para criar um novo passo do modo de preparo
function criarPassoModoPreparo(passo = '') {
    const modoPreparoLista = document.getElementById('modo-preparo-lista');
    const novoPasso = document.createElement('li');

    const textarea = document.createElement('textarea');
    textarea.name = 'modo-preparo-passo';
    textarea.placeholder = `Passo ${modoPreparoLista.children.length + 1}`;
    textarea.rows = 3;
    textarea.required = true;
    textarea.textContent = passo;
    novoPasso.appendChild(textarea);

    const button = document.createElement('button');
    button.type = 'button';
    button.addEventListener('click', () => removerPasso(button));
    const icon = document.createElement('i');
    icon.classList.add('fas', 'fa-trash-alt');
    button.appendChild(icon);
    novoPasso.appendChild(button);

    modoPreparoLista.appendChild(novoPasso);
}

// Função para remover um passo do modo de preparo
function removerPasso(botaoRemover) {
    const modoPreparoLista = document.getElementById('modo-preparo-lista');
    modoPreparoLista.removeChild(botaoRemover.parentNode);
    atualizarNumeracaoPassos();
}

// Função para atualizar a numeração dos passos após a remoção
function atualizarNumeracaoPassos() {
    const modoPreparoLista = document.getElementById('modo-preparo-lista');
    const passos = modoPreparoLista.getElementsByTagName('li');
    for (let i = 0; i < passos.length; i++) {
        passos[i].querySelector('textarea').setAttribute('placeholder', `Passo ${i + 1}`);
    }
}

// Adiciona as opções de unidade de medida ao select
const unidadesMedida = ["gramas", "mililitros", "colheres de sopa", "colheres de chá"];
const selectUnidadeMedida = document.getElementById('unidade-medida');
unidadesMedida.forEach(unidade => {
    const option = document.createElement('option');
    option.value = unidade;
    option.textContent = unidade;
    selectUnidadeMedida.appendChild(option);
});

// Adiciona o evento de clique ao botão "Adicionar Ingrediente"
document.getElementById('btn-adicionar-ingrediente').addEventListener('click', () => criarCampoIngrediente());

// Adiciona o evento de clique ao botão "Adicionar Passo"
document.getElementById('btn-adicionar-passo').addEventListener('click', () => criarPassoModoPreparo());
