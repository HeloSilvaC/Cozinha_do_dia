
document.addEventListener("DOMContentLoaded", function () {
    const btnAdicionarIngrediente = document.getElementById("btn-adicionar-ingrediente");
    const btnAdicionarPasso = document.getElementById("btn-adicionar-passo");
    const modoPreparoLista = document.getElementById("modo-preparo-lista");
    const ingredientesContainer = document.getElementById('organizar');
    // Clonar o primeiro ingrediente para garantir consistência nos estilos
    const modeloIngrediente = document.querySelector(".ingrediente").cloneNode(true);

    // Adicionar um novo campo de ingrediente quando o botão "Adicionar Novo Ingrediente" é clicado
    btnAdicionarIngrediente.addEventListener("click", function () {
        const novoIngrediente = modeloIngrediente.cloneNode(true);

        // Remover o botão de remover existente (se houver)
        const botaoRemoverExistente = novoIngrediente.querySelector(".btn-remover");
        if (botaoRemoverExistente) {
            botaoRemoverExistente.remove();
        }

        // Botão de remover o ingrediente
        const btnRemoverIngrediente = document.createElement("button");
        btnRemoverIngrediente.type = "button";
        btnRemoverIngrediente.classList.add("btn-remover");
        btnRemoverIngrediente.innerHTML = '<i class="fa fa-trash"></i>';
        btnRemoverIngrediente.addEventListener("click", function () {
            novoIngrediente.remove();
        });

        // Adicionar o novo botão de remover ao novo ingrediente
        novoIngrediente.appendChild(btnRemoverIngrediente);

        // Adicionar o novo ingrediente ao contêiner
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