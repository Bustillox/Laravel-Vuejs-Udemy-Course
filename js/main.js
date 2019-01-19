var app = new Vue({
    el : '#app',
    data : {
        // message: "Hello Vue.js!"
        list : [],
        name: '',
        grade: ''
    },
    methods: {
        addGrade: function (){
            stateA = false;
            if (this.grade >= 70) {
                stateA = true;
            }
            if (this.name!="" && this.grade!="") {
                this.list.push({name:this.name, grade:this.grade, state:stateA});
                this.name = "";
                this.grade = "";
            }else{
                alert("Please insert the name and the grade of the student");
            }
        }
    },
})