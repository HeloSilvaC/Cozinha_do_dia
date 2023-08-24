<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Seu cabeçalho HTML aqui -->
</head>
<body>
    <div id="recipe-details">
        <!-- Os detalhes da receita serão inseridos aqui pelo JavaScript -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Função para obter o nome da receita da URL
            function getRecipeName() {
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                const recipeName = urlParams.get('search');
                return recipeName || ''; // Certifique-se de que é uma string vazia se não houver nome na URL
            }

            // Chame a função para obter o nome da receita
            const recipeName = getRecipeName().toLowerCase(); // Converter para minúsculas

            // URL do arquivo JSON de receitas
            const recipeDataUrl = "../receitas.json";

            // Carregar o arquivo JSON de receitas
            fetch(recipeDataUrl)
                .then(response => response.json())
                .then(data => {
                    // Encontre a receita correspondente pelo nome (em minúsculas)
                    const recipe = data.find(recipe => recipe.nome.toLowerCase() === recipeName.toLowerCase());

                    if (recipe) {
                        // Exibe os detalhes da receita na página
                        const recipeContainer = document.getElementById('recipe-details');

                        const ingredientsSection = recipe.secao.find(secao => secao.nome === ' Ingredientes');
                        const ingredientsList = ingredientsSection.conteudo;

                        let ingredientsHTML = '<h2>' + recipe.nome + '</h2>';
                        ingredientsHTML += '<p>Ingredientes:</p>';

                        ingredientsList.forEach(ingredient => {
                            if (ingredient.trim() !== '') {
                                // Verifique se o ingrediente é completamente maiúsculo
                                const isAllUpperCase = ingredient === ingredient.toUpperCase();
                                // Se for tudo maiúsculas, não inclua um checkbox
                                if (isAllUpperCase) {
                                    ingredientsHTML += `<div>${ingredient}</div>`;
                                } else {
                                    ingredientsHTML += `
                                        <div>
                                            <input type="checkbox" value="${ingredient}" id="ingredient-${ingredient.replace(/\s+/g, '-')}">
                                            <label for="ingredient-${ingredient.replace(/\s+/g, '-')}">${ingredient}</label>
                                        </div>
                                    `;
                                }
                            }
                        });

                        const preparationSection = recipe.secao.find(secao => secao.nome === ' Modo de Preparo');
                        const preparationSteps = preparationSection.conteudo;

                        let preparationHTML = '<h3>Modo de Preparo:</h3>';
                        preparationHTML += '<ol>';

                        let stepNumber = 0; // Inicializar o número do passo

                        preparationSteps.forEach(step => {
                            if (step.trim() !== '') {
                                // Verificar se o passo é completamente maiúsculo
                                const isAllUpperCase = step === step.toUpperCase();
                                if (isAllUpperCase) {
                                    // Reiniciar o número do passo
                                    stepNumber = 0;
                                    preparationHTML += `<li>${step}</li>`;
                                } else {
                                    // Incrementar o número do passo
                                    stepNumber++;
                                    preparationHTML += `<li><span class="step-number">${stepNumber}.</span> ${step}</li>`;
                                }
                            }
                        });

                        preparationHTML += '</ol>';

                        recipeContainer.innerHTML = ingredientsHTML + preparationHTML;
                    } else {
                        // Caso nenhuma receita correspondente seja encontrada
                        const recipeContainer = document.getElementById('recipe-details');
                        recipeContainer.innerHTML = 'Nenhuma receita correspondente encontrada.';
                    }
                })
                .catch(error => {
                    console.error('Ocorreu um erro ao buscar os detalhes da receita:', error);
                });
        });
    </script>
</body>
</html>
