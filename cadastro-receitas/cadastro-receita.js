document.addEventListener("DOMContentLoaded", function () {
    const btnAdicionarIngrediente = document.getElementById("btn-adicionar-ingrediente");
    const btnAdicionarPasso = document.getElementById("btn-adicionar-passo");
    const modoPreparoLista = document.getElementById("modo-preparo-lista");
    const ingredientesContainer = document.querySelector(".ingredientes-container");

    // Adicionar um novo campo de ingrediente quando o botão "Adicionar Novo Ingrediente" é clicado
    btnAdicionarIngrediente.addEventListener("click", function () {
        const novoIngrediente = document.createElement("div");
        novoIngrediente.classList.add("ingrediente");

        // Campo do nome do ingrediente
        const inputNome = document.createElement("input");
        inputNome.type = "text";
        inputNome.name = "ingredientes[]";
        inputNome.placeholder = "Nome do ingrediente";
        inputNome.required = true;

        // Campo da quantidade do ingrediente
        const inputQuantidade = document.createElement("input");
        inputQuantidade.type = "number";
        inputQuantidade.name = "quantidades[]";
        inputQuantidade.placeholder = "Quantidade";
        inputQuantidade.required = true;
        inputQuantidade.min = "0";

        // Campo da unidade de medida
        const selectUnidade = document.createElement("select");
        selectUnidade.name = "unidades[]";
        selectUnidade.required = true;

        const optionEscolher = document.createElement("option");
        optionEscolher.value = "";
        optionEscolher.disabled = true;
        optionEscolher.selected = true;
        optionEscolher.textContent = "Escolher unidade";

        const optionGrama = document.createElement("option");
        optionGrama.value = "g";
        optionGrama.textContent = "grama(s)";

        const optionQuilograma = document.createElement("option");
        optionQuilograma.value = "kg";
        optionQuilograma.textContent = "quilograma(s)";

        const optionMililitro = document.createElement("option");
        optionMililitro.value = "ml";
        optionMililitro.textContent = "mililitro(s)";

        const optionLitro = document.createElement("option");
        optionLitro.value = "l";
        optionLitro.textContent = "litro(s)";

        const optionUnidade = document.createElement("option");
        optionUnidade.value = "un";
        optionUnidade.textContent = "unidade(s)";

        selectUnidade.appendChild(optionEscolher);
        selectUnidade.appendChild(optionGrama);
        selectUnidade.appendChild(optionQuilograma);
        selectUnidade.appendChild(optionMililitro);
        selectUnidade.appendChild(optionLitro);
        selectUnidade.appendChild(optionUnidade);

        // Botão de remover o ingrediente
        const btnRemoverIngrediente = document.createElement("button");
        btnRemoverIngrediente.type = "button";
        btnRemoverIngrediente.classList.add("btn-remover");
        btnRemoverIngrediente.innerHTML = '<i class="fa fa-trash"></i>';
        btnRemoverIngrediente.addEventListener("click", function () {
            novoIngrediente.remove();
        });

        novoIngrediente.appendChild(inputNome);
        novoIngrediente.appendChild(inputQuantidade);
        novoIngrediente.appendChild(selectUnidade);
        novoIngrediente.appendChild(btnRemoverIngrediente);

        ingredientesContainer.appendChild(novoIngrediente);
    });

    // Adicionar um novo passo de preparo quando o botão "Adicionar Novo Passo" é clicado
    btnAdicionarPasso.addEventListener("click", function () {
        const novoPasso = document.createElement("li");

        const textarea = document.createElement("textarea");
        textarea.name = `modo-preparo[]`;
        textarea.placeholder = `Passo ${modoPreparoLista.children.length + 1}`;
        textarea.rows = "3";
        textarea.required = true;

        // Adicionar um botão de remover ao novo passo
        const btnRemoverPasso = document.createElement("button");
        btnRemoverPasso.type = "button";
        btnRemoverPasso.classList.add("btn-remover");
        btnRemoverPasso.innerHTML = '<i class="fa fa-trash"></i>';
        btnRemoverPasso.addEventListener("click", function () {
            novoPasso.remove();

            // Atualizar o número dos passos após a remoção
            const passos = modoPreparoLista.children.length;
            for (let i = 0; i < passos; i++) {
                const textarea = modoPreparoLista.children[i].querySelector("textarea");
                textarea.placeholder = `Passo ${i + 1}`;
            }
        });

        novoPasso.appendChild(textarea);
        novoPasso.appendChild(btnRemoverPasso);
        modoPreparoLista.appendChild(novoPasso);
    });

    document.getElementById('imagens-receita').addEventListener('change', function (event) {
        var visualizacao = document.getElementById('visualizacao');

        for (var i = 0; i < event.target.files.length; i++) {
            var file = event.target.files[i];
            var imageType = /image.*/;

            if (!file.type.match(imageType)) {
                continue;
            }

            var container = document.createElement('div'); // Container para a imagem e o botão "X"
            container.classList.add('image-container');

            var img = document.createElement('img');
            img.classList.add('thumbnail');
            img.src = URL.createObjectURL(file);

            var removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('btn-remove');

            // Adicionando o ícone "delete" do Google Material Symbols Outlined
            removeButton.innerHTML = '<span class="material-symbols-outlined" style="font-size: 14px; padding: 3px; border-radius: 50%; background: none;">delete</span>';

            removeButton.addEventListener('click', function () {
                container.remove();
            });

            container.appendChild(img);
            container.appendChild(removeButton);

            visualizacao.appendChild(container);
        }
    });

});
