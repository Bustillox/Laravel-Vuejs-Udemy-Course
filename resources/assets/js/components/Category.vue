<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Categorías
                    <button type="button" @click="openModal('category', 'register')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criteria">
                                <option value="name">Nombre</option>
                                <option value="description">Descripción</option>
                                </select>
                                <input type="text" v-model="search" @keyup.enter="listCategory(1,search,criteria)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listCategory(1,search,criteria)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in arrayCategory" :key="category.id">
                                <td>
                                    <button type="button" @click="openModal('category', 'update', category)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template v-if="category.condition">
                                        <button type="button" class="btn btn-danger btn-sm" @click="deactivateCategory(category.id)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-info btn-sm" @click="activateCategory(category.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>
                                </td>
                                <td v-text="category.name"></td>
                                <td v-text="category.description"></td>
                                <td>
                                    <div v-if="category.condition">
                                        <span class="badge badge-success">Activo</span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-danger">Desactivado</span>
                                    </div> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page - 1,search,criteria);">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="changePage(page,search,criteria)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1,search,criteria)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'show': modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="modalTitle"></h4>
                        <button type="button" class="close" @click="closeModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="name" class="form-control" placeholder="Nombre de categoría">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="description" class="form-control" placeholder="Ingrese descripcion de la categoria">
                                </div>
                            </div>
                            <div v-show="categoryError" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in categoryShowErrorMsg" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                        <button type="button" v-if="actionType==1" class="btn btn-primary" @click="registerCategory()">Guardar</button>
                        <button type="button" v-if="actionType==2" class="btn btn-primary" @click="updateCategory()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
    export default {
        data(){
            return{
                //Global Variables
                category_id: 0,
                name: '',
                description: '',
                arrayCategory: [],

                //Modal Variables
                modal: 0,
                modalTitle: '',
                actionType: 0,

                //Validate Category
                categoryError: 0,
                categoryShowErrorMsg: [],

                //Pagination
                pagination: {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset: 3,
                criteria: 'name',
                search: ''
            }
        },
        computed:{

            //Activated(?)
            isActived: function(){
                return this.pagination.current_page;
            },

            //Calculates the pagination elements
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
            }
        },
        methods:{
            listCategory(page,search,criteria){
                let me = this;
                var url = '/categoria?page=' + page + '&search=' + search + '&criteria=' + criteria;
                
                //Categories table registries
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    // handle success
                    me.arrayCategory = respuesta.categories.data;
                    me.pagination = respuesta.pagination;
                    // console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            changePage(page, search, criteria){
                let me = this;

                //Update the current page
                me.pagination.current_page = page;

                //Send the current page view data request
                me.listCategory(page, search, criteria);
            },
            registerCategory(){

                if (this.validateCategory()) {
                    return;
                }

                let me = this;

                axios.post('/categoria/registrar', {
                    'name': this.name,
                    'description': this.description
                }).then(function (response){
                    //Executed Succesfully
                    me.closeModal();
                    me.listCategory(1,'','name');
                }).catch(function (error) {
                        console.log(error);
                });

            },
            updateCategory(){

                if (this.validateCategory()) {
                    return;
                }

                let me = this;

                axios.put('/categoria/actualizar', {
                    'name': this.name,
                    'description': this.description,
                    'id': this.category_id
                }).then(function (response){
                    //Executed Succesfully
                    me.closeModal();
                    me.listCategory(1,'','name');
                }).catch(function (error) {
                        console.log(error);
                });
            },
            deactivateCategory(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Desactivar Categoría',
                text: "Esta seguro que quiere desactivar esta categoria?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {

                    let me = this;

                    axios.put('/categoria/desactivar', {
                        'id': id
                    }).then(function (response){
                        //Executed Succesfully
                        me.listCategory(1,'','name');

                        swalWithBootstrapButtons.fire(
                        'Eliminado Satisfactoriamente!',
                        'El registro ha sido desactivado satisfactoriamente.',
                        'success'
                        )
                    }).catch(function (error) {
                            console.log(error);
                    });

                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
                })
            },
            activateCategory(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Activar Categoría',
                text: "Esta seguro que quiere activar esta categoria?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {

                    let me = this;

                    axios.put('/categoria/activar', {
                        'id': id
                    }).then(function (response){
                        //Executed Succesfully
                        me.listCategory(1,'','name');

                        swalWithBootstrapButtons.fire(
                        'Activado!',
                        'El registro ha sido activado satisfactoriamente.',
                        'success'
                        )
                    }).catch(function (error) {
                            console.log(error);
                    });

                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
                })
            },
            validateCategory(){
                this.categoryError=0;
                this.categoryShowErrorMsg = [];

                if(!this.name) this.categoryShowErrorMsg.push('El Nombre de la categoria no puede estar vacío.');
                if (this.categoryShowErrorMsg.length) this.categoryError = 1;
                
                return this.categoryError;
            },
            closeModal(){
                this.modal = 0;
                this.modalTitle = '';
                this.name = '';
                this.description = '';
            },
            openModal(model, action, data = []){
                switch (model) {
                    case "category":
                    {
                        switch (action) {
                            case 'register':
                            {
                                //Show Modal
                                this.modal = 1;
                                this.modalTitle = 'Registrar Categoria';
                                this.name = '';
                                this.description = '';
                                this.actionType = 1;
                                break;
                            }
                            case 'update':
                            {
                                // console.log(data);
                                this.modal = 1;
                                this.modalTitle = 'Actualizar Categoría';
                                this.actionType = 2;
                                this.category_id = data['id'];
                                this.name = data['name'];
                                this.description = data['description'];
                                break;

                            }
                        }
                    }
                }

            }
        },
        mounted() {
            this.listCategory(1,this.search,this.criteria);
            console.log('Component mounted.')
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .show{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
