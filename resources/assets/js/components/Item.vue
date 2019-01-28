<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Artículos
                    <button type="button" @click="openModal('item', 'register')" class="btn btn-secondary">
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
                                <input type="text" v-model="search" @keyup.enter="listItem(1,search,criteria)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listItem(1,search,criteria)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio de Venta</th>
                                <th>Stock</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in arrayItem" :key="item.id">
                                <td>
                                    <button type="button" @click="openModal('item', 'update', item)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template v-if="item.condition">
                                        <button type="button" class="btn btn-danger btn-sm" @click="deactivateItem(item.id)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-info btn-sm" @click="activateItem(item.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>
                                </td>
                                <td v-text="item.code"></td>
                                <td v-text="item.name"></td>
                                <td v-text="item.category_name"></td>
                                <td v-text="item.sale_price"></td>
                                <td v-text="item.stock"></td>
                                <td v-text="item.description"></td>
                                <td>
                                    <div v-if="item.condition">
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
                                <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                                <div class="col-md-9">
                                    <!-- <v-select v-model="arrayCategory" :options="[{label: arrayCategory, value: arrayCategory}]">
                                    </v-select> -->
                                    <select class="form-control" v-model="id_category">
                                        <option value="0" disabled>Seleccione una Categoría</option>
                                        <option v-for="category in arrayCategory" :key="category.id" :value="category.id" v-text="category.name"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="code" class="form-control" placeholder="Código de Barras">
                                    <barcode :value="code" :options="{format: 'EAN-13'}">
                                        Generando código de barras...
                                    </barcode>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="name" class="form-control" placeholder="Nombre de artículo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Precio de Venta</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="sale_price" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Stock</label>
                                <div class="col-md-9">
                                    <input type="number" v-model="stock" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="description" class="form-control" placeholder="Ingrese descripcion de la categoria">
                                </div>
                            </div>
                            <div v-show="itemError" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in itemShowErrorMsg" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                        <button type="button" v-if="actionType==1" class="btn btn-primary" @click="registerItem()">Guardar</button>
                        <button type="button" v-if="actionType==2" class="btn btn-primary" @click="updateItem()">Actualizar</button>
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
    // //Barcode
    // import VueBarcode from 'vue-barcode';
    export default {
        data(){
            return{
                //Global Variables
                item_id: 0,
                id_category: 0,
                category_name: '',
                code: '',
                name: '',
                sale_price: 0,
                stock: 0,
                description: '',
                arrayItem: [],

                //Modal Variables
                modal: 0,
                modalTitle: '',
                actionType: 0,

                //Validate Item
                itemError: 0,
                itemShowErrorMsg: [],

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
                search: '',
                arrayCategory: [],
            }
        },
        // components: {
        //     'barcode': VueBarcode
        // },
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
            listItem(page,search,criteria){
                let me = this;
                var url = '/articulo?page=' + page + '&search=' + search + '&criteria=' + criteria;
                
                //Categories table registries
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    // handle success
                    me.arrayItem = respuesta.items.data;
                    me.pagination = respuesta.pagination;
                    // console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            selectCategory(){
                let me = this;
                var url = '/categoria/selectCategoria';
                
                //Categories table registries
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    // handle success
                    me.arrayCategory = respuesta.categories;
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
                me.listItem(page, search, criteria);
            },
            registerItem(){

                if (this.validateItem()) {
                    return;
                }

                let me = this;

                axios.post('/articulo/registrar', {
                    'id_category':this.id_category,
                    'code': this.code,
                    'name': this.name,
                    'stock': this.stock,
                    'sale_price': this.sale_price,
                    'description': this.description
                }).then(function (response){
                    //Executed Succesfully
                    me.closeModal();
                    me.listItem(1,'','name');
                }).catch(function (error) {
                        console.log(error);
                });

            },
            updateItem(){

                if (this.validateItem()) {
                    return;
                }

                let me = this;

                axios.put('/articulo/actualizar', {
                    'id_category':this.id_category,
                    'code': this.code,
                    'name': this.name,
                    'stock': this.stock,
                    'sale_price': this.sale_price,
                    'description': this.description,
                    'id': this.item_id
                }).then(function (response){
                    //Executed Succesfully
                    me.closeModal();
                    me.listItem(1,'','name');
                }).catch(function (error) {
                        console.log(error);
                });
            },
            deactivateItem(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Desactivar Artículo',
                text: "Esta seguro que quiere desactivar este artículo?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {

                    let me = this;

                    axios.put('/articulo/desactivar', {
                        'id': id
                    }).then(function (response){
                        //Executed Succesfully
                        me.listItem(1,'','name');

                        swalWithBootstrapButtons.fire(
                        'Desactivado Satisfactoriamente!',
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
            activateItem(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Activar Artículo',
                text: "Esta seguro que quiere activar este artículo?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {

                    let me = this;

                    axios.put('/articulo/activar', {
                        'id': id
                    }).then(function (response){
                        //Executed Succesfully
                        me.listItem(1,'','name');

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
            validateItem(){
                this.itemError=0;
                this.itemShowErrorMsg = [];

                if(this.id_category == 0) this.itemShowErrorMsg.push('Seleccione una categoría.');
                if(!this.name) this.itemShowErrorMsg.push('El Nombre del artículo no puede estar vacío.');
                if(!this.stock) this.itemShowErrorMsg.push('El stock del artículo debe de ser un numero y no puede estar vacío.');
                if(!this.sale_price) this.itemShowErrorMsg.push('El precio de venta del artículo debe de ser un número y no puede estar vacio');

                if (this.itemShowErrorMsg.length) this.itemError = 1;
                
                return this.itemError;
            },
            closeModal(){
                this.modal = 0;
                this.modalTitle = '';
                this.id_category = 0;
                this.category_name = '';
                this.code = '';
                this.name = '';
                this.sale_price = 0;
                this.stock = 0;
                this.description = '';
                this.itemError = 0;
            },
            openModal(model, action, data = []){
                switch (model) {
                    case "item":
                    {
                        switch (action) {
                            case 'register':
                            {
                                //Show Modal
                                this.modal = 1;
                                this.modalTitle = 'Registrar Artículo';
                                this.id_category = 0;
                                this.category_name = '';
                                this.code = '';
                                this.name = '';
                                this.sale_price = 0;
                                this.stock = 0;
                                this.description = '';
                                this.actionType = 1;
                                break;
                            }
                            case 'update':
                            {
                                // console.log(data);
                                this.modal = 1;
                                this.modalTitle = 'Actualizar Artículo';
                                this.actionType = 2;
                                this.item_id = data['id'];
                                this.id_category = data['id_category'];
                                this.code = data['code'];
                                this.name = data['name'];
                                this.stock = data['stock'];
                                this.sale_price = data['sale_price'];
                                this.description = data['description'];
                                break;

                            }
                        }
                    }
                }
                this.selectCategory();

            }
        },
        mounted() {
            this.listItem(1,this.search,this.criteria);
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
