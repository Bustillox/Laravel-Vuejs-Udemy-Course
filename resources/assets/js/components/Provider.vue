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
                    <i class="fa fa-align-justify"></i> Proveedores
                    <button type="button" @click="openModal('customer', 'register')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criteria">
                                <option value="name">Nombre</option>
                                <option value="document_number">Documento</option>
                                <option value="email">Email</option>
                                <option value="phone">Telefono</option>
                                </select>
                                <input type="text" v-model="search" @keyup.enter="listCustomer(1,search,criteria)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listCustomer(1,search,criteria)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Tipo de Documento</th>
                                <th>Número</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Correo Electrónico</th>
                                <th>Contacto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="customer in arrayCustomer" :key="customer.id">
                                <td>
                                    <button type="button" @click="openModal('customer', 'update', customer)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                    </button>
                                </td>
                                <td v-text="customer.name"></td>
                                <td v-text="customer.document_type"></td>
                                <td v-text="customer.document_number"></td>
                                <td v-text="customer.address"></td>
                                <td v-text="customer.phone"></td>
                                <td v-text="customer.email"></td>
                                <td v-text="customer.contact"></td>
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
                                    <input type="text" v-model="name" class="form-control" placeholder="Nombre del cliente">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Tipo de Documento</label>
                                <div class="col-md-9">
                                    <select v-model="document_type" class="form-control">
                                        <option value="RFC">RFC</option>
                                        <option value="RUC">RUC</option>
                                        <option value="PASS">PASS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Número</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="document_number" class="form-control" placeholder="Número del Documento">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Dirección</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="address" class="form-control" placeholder="Dirección">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Teléfono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="phone" class="form-control" placeholder="Teléfono">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Email</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div v-show="customerError" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in customerShowErrorMsg" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                        <button type="button" v-if="actionType==1" class="btn btn-primary" @click="registerCustomer()">Guardar</button>
                        <button type="button" v-if="actionType==2" class="btn btn-primary" @click="updateCustomer()">Actualizar</button>
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
                customer_id: 0,
                name: '',
                document_type: 'RFC',
                document_number: '',
                address: '',
                phone: '',
                email: '',
                contact: '',
                contact_phone: '',

                arrayCustomer: [],

                //Modal Variables
                modal: 0,
                modalTitle: '',
                actionType: 0,

                //Validate Customer
                customerError: 0,
                customerShowErrorMsg: [],

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
            listCustomer(page,search,criteria){
                let me = this;
                var url = '/proveedor?page=' + page + '&search=' + search + '&criteria=' + criteria;
                
                //Categories table registries
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    // handle success
                    me.arrayCustomer = respuesta.customers.data;
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
                me.listCustomer(page, search, criteria);
            },
            registerCustomer(){

                if (this.validateCustomer()) {
                    return;
                }

                let me = this;

                axios.post('/cliente/registrar', {
                    'name': this.name,
                    'document_type': this.document_type,
                    'document_number': this.document_number,
                    'address': this.address,
                    'phone': this.phone,
                    'email': this.email,
                }).then(function (response){
                    //Executed Succesfully
                    me.closeModal();
                    me.listCustomer(1,'','name');
                }).catch(function (error) {
                        console.log(error);
                });

            },
            updateCustomer(){

                if (this.validateCustomer()) {
                    return;
                }

                let me = this;

                axios.put('/cliente/actualizar', {
                    'name': this.name,
                    'document_type': this.document_type,
                    'document_number': this.document_number,
                    'address': this.address,
                    'phone': this.phone,
                    'email': this.email,
                    'id': this.customer_id
                }).then(function (response){
                    //Executed Succesfully
                    me.closeModal();
                    me.listCustomer(1,'','name');
                }).catch(function (error) {
                        console.log(error);
                });
            },
            validateCustomer(){
                this.customerError=0;
                this.customerShowErrorMsg = [];

                if(!this.name) this.customerShowErrorMsg.push('El Nombre del cliente no puede estar vacío.');
                if (this.customerShowErrorMsg.length) this.customerError = 1;
                
                return this.customerError;
            },
            closeModal(){
                this.modal = 0;
                this.modalTitle = '';
                this.name = '';
                this.document_type = 'RFC';
                this.document_number = '';
                this.address = '';
                this.phone = '';
                this.email = '';
                this.customerError = 0;
            },
            openModal(model, action, data = []){
                switch (model) {
                    case "customer":
                    {
                        switch (action) {
                            case 'register':
                            {
                                //Show Modal
                                this.modal = 1;
                                this.modalTitle = 'Registrar Cliente';
                                this.name = '';
                                this.document_type = 'RFC';
                                this.document_number = '';
                                this.address = '';
                                this.phone = '';
                                this.email = '';

                                this.actionType = 1;
                                break;
                            }
                            case 'update':
                            {
                                // console.log(data);
                                this.modal = 1;
                                this.modalTitle = 'Actualizar Cliente';
                                this.customer_id = data['id'];
                                this.name = data['name'];
                                this.document_type = data['document_type'];
                                this.document_number = data['document_number'];
                                this.address = data['address'];
                                this.phone = data['phone'];
                                this.email = data['email'];
                                
                                this.actionType = 2;
                                break;

                            }
                        }
                    }
                }

            }
        },
        mounted() {
            this.listCustomer(1,this.search,this.criteria);
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
