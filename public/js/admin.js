let category = new DataTable('#category');
let factory = new DataTable('#factory');
let product = new DataTable('#product');
let materials = new DataTable('#materials');
let component = new DataTable('#component');
let production = new DataTable('#production');
let customer = new DataTable('#customer');
document.getElementById('addMaterialInput').addEventListener('click', function() {
    const template = document.getElementById('template');
    const inputMaterials = document.getElementById('inputMaterials');
    const newMaterialInput = template.cloneNode(true);
    newMaterialInput.style.display = 'block';
    const deleteButton = document.createElement('button');
    deleteButton.textContent = 'Hapus';
    deleteButton.addEventListener('click', function() {
        this.parentElement.remove();
    });
    newMaterialInput.appendChild(deleteButton);
    inputMaterials.appendChild(newMaterialInput);
});