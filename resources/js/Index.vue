<template lang="pug">
    div.container
        div.row
            div.col-md-4
                form(@submit.prevent="onSubmit")
                    div.form-group
                    label Task:
                    input(type="text" v-model="taskForm.name" class="form-control" required)
                    div.form-group
                    label Description:
                    textarea(class="form-control" v-model="taskForm.description" rows="4" cols="50" required)
                    button(type="submit" class="btn btn-success form-control") Save Task
            div.col-md-8
                table.table
                    thead
                        tr
                            th ID
                            th TASK
                            th DESCRIPTION
                            th ACTION
                    tbody
                        template(v-for="datum in data")
                            tr(v-bind:key="datum.id")
                                td {{datum.id}}
                                td {{datum.name}}
                                td {{datum.description}}
                                td
                                    a(href="#" v-on:click="retrieveData(datum.id)" class="btn btn-primary") Edit  
                                    a(href="#" v-on:click="deleteData(datum.id)" class="btn btn-danger") Delete

</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            data: {},
            baseUrl: "http://localhost:8000/task",
            insert: true,
            taskForm: {
                id: "",
                name: "",
                description: ""
            }
        }
    },
    async created () {
        try {
            const response = await axios.get(this.baseUrl)
            this.data = response.data
        } catch (e) {
            //
        }
    },
    methods: {
        onSubmit() {
            if (this.insert === true) {
                this.insertTask()
            } else {
                this.updateTask()
            }
            this.insert = true
        },

        async insertTask() {
            axios.post(this.baseUrl + '/insert', this.taskForm)
            .then(response => {
                this.data.unshift(response.data);
                this.taskForm = {
                    id: "",
                    name: "",
                    description: ""
                }
                alert("Successfully Added");
            })
            .catch(error => {
                //
            })
        },

        async updateTask() {
            axios.post(this.baseUrl + '/update/' + this.taskForm.id, this.taskForm)
            .then(response => {
                this.taskForm = {
                    id: "",
                    name: "",
                    description: ""
                }
                this.getAllData()
                alert("Successfully Updated");
            })
            .catch(error => {
                //
            })
        },

        async retrieveData(id) {
            axios.get(this.baseUrl + '/find/' + id)
            .then(response => {
                this.taskForm = response.data
                this.insert = false
            })
            .catch(error => {
                //
            })
        },

        async deleteData(id) {
            if (confirm("Are you sure you want to delete?")) {
                axios.get(this.baseUrl + '/delete/' + id)
                .then(response => {
                    this.getAllData()
                })
                .catch(error => {
                    //
                })
            }
        },

        async getAllData() {
            const response = await axios.get(this.baseUrl)
            this.data = response.data
        }
    }
}
</script>
