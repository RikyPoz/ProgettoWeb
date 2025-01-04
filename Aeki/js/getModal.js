async function getModal() {
    try {
        // richiesta al server per ottenere i dati (materiali, colori, ambienti, categorie)
        const response = await fetch('Ajax/api-getInfo.php');
        const result = await response.json();
        console.log(result);

        if (!result.success) {
            throw new Error('Errore nel recupero dei dati');
        }

        // Recupera i dati dal risultato
        const materials = result.data.materials;
        const colors = result.data.colors;
        const environments = result.data.environments;
        const categories = result.data.categories;


        // Genera l'HTML del modale

        let html = `
                <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content modal-custom-width">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addProductModalLabel">Aggiungi un nuovo prodotto</h5>
                                <button type="button" class="btn-close" id="addProductModalClose" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body modal-custom-height">
                                <form id="addProductForm">
                                    <!-- Prima riga -->
                                    <div class="row d-flex justify-content-center">
                                        <!-- Colonna 1 -->
                                        <div class="col-md-4 mb-3">
                                            <label for="productName" class="form-label">Nome prodotto</label>
                                            <input type="text" class="form-control" id="productName" required>
                                        </div>

                                        <!-- Colonna 2 -->
                                        <div class="col-md-4 mb-3">
                                            <label for="productPrice" class="form-label">Prezzo (€)</label>
                                            <input type="number" class="form-control" id="productPrice" min="0" step="0.01" required>
                                        </div>

                                    </div>

                                    <!-- Seconda riga -->
                                    <div class="row">
                                        <!-- Colonna 1 -->
                                        <div class="col-md-4 mb-3">
                                            <label for="productWidth" class="form-label">Larghezza (cm)</label>
                                            <input type="number" class="form-control" id="productWidth" min="0" required>
                                        </div>

                                        <!-- Colonna 2 -->
                                        <div class="col-md-4 mb-3">
                                            <label for="productDepth" class="form-label">Profondità (cm)</label>
                                            <input type="number" class="form-control" id="productDepth" min="0" required>
                                        </div>

                                        <!-- Colonna 3 -->
                                        <div class="col-md-4 mb-3">
                                            <label for="productHeight" class="form-label">Altezza (cm)</label>
                                            <input type="number" class="form-control" id="productHeight" min="0" required>
                                        </div>
                                    </div>

                                    <!-- Terza riga -->
                                    <div class="row d-flex justify-content-center">
                                        <!-- Colonna 1 -->
                                        <div class="col-md-4 mb-3">
                                            <label for="productEnvironment" class="form-label">Ambiente</label>
                                            <select class="form-control" id="productEnvironment" required>
                                                <option value="">Seleziona un ambiente</option>
                                                ${environments.map(environment => `
                                                    <option value="${environment.NomeAmbiente}">${environment.NomeAmbiente}</option>
                                                `).join('')}
                                            </select>
                                        </div>

                                        <!-- Colonna 2 -->
                                        <div class="col-md-4 mb-3">
                                            <label for="productCategory" class="form-label">Categoria</label>
                                            <select class="form-control" id="productCategory" required>
                                                <option value="">Seleziona una categoria</option>
                                                ${categories.map(category => `
                                                    <option value="${category.NomeCategoria}">${category.NomeCategoria}</option>
                                                `).join('')}
                                            </select>
                                        </div>

                                    </div>

                                    <!-- Quarta riga -->
                                    <div class="row d-flex justify-content-center">
                                        <!-- Colonna 1 -->
                                        <div class="col-md-4 mb-3">
                                            <label for="productMaterial" class="form-label">Materiale</label>
                                            <select class="form-control" id="productMaterial" required>
                                                <option value="">Seleziona un materiale</option>
                                                ${materials.map(material => `
                                                    <option value="${material.NomeMateriale}">${material.NomeMateriale}</option>
                                                `).join('')}
                                            </select>
                                        </div>

                                        <!-- Colonna 2 -->
                                        <div class="col-md-4 mb-3">
                                            <label for="productColor" class="form-label">Colore</label>
                                            <select class="form-control" id="productColor" required>
                                                <option value="">Seleziona un colore</option>
                                                ${colors.map(color => `
                                                    <option value="${color.NomeColore}">${color.NomeColore}</option>
                                                `).join('')}
                                            </select>
                                        </div>

                                    </div>

                                    <!-- Quinta riga -->
                                    <div class="row">
                                        <!-- Colonna 1 -->
                                        <div class="col-md-12 mb-3">
                                            <label for="productDescription" class="form-label">Descrizione</label>
                                            <textarea class="form-control" id="productDescription" rows="4" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Sesta riga -->
                                    <div class="row d-flex justify-content-center">
                                        <!-- Colonna 1 -->
                                        <div class="col-md-8 mb-3">
                                            <label for="productImage" class="form-label">Immagine prodotto</label>
                                            <input type="file" class="form-control" id="productImage" accept="image/*" required>
                                        </div>
                                    </div>

                                    
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                <button type="button" class="btn btn-primary" id="saveProductBtn">Salva</button>
                            </div>
                        </div>
                    </div>
                </div>`;

        console.log(html);
        return html;

    } catch (error) {
        console.error('Errore nel recupero dei dati del modale:', error);
        return '<p>Errore nel recupero dei dati. Riprova più tardi.</p>';
    }
}
