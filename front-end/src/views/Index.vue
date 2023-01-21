<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

export default {
    components: { Datepicker },
    data() {
        return {
            count: 0,
            date: new Date(),
            dataStudents: [],
            dataAssists: [],
        }
    },
    mounted() {
        this.axios.get('http://127.0.0.1:8000/api/students').then((response) => {
            this.dataStudents = response.data
        });
        this.getAssists();
    },
    methods: {
        getAssists() {
            this.axios.get(`http://127.0.0.1:8000/api/assists/${this.mysqlDate()}`).then((response) => {
                if (response.data) {
                    this.dataAssists = response.data;
                } else {
                    this.dataAssists = [];
                }
            });
        },
        setAssist(id, status) {
            let student = this.getStudentAssist(id);
            if (student==null) {
                this.dataAssists.push({
                    id: id,
                    status: status,
                });
            } else {
                student.status = status;
            }
        },
        mysqlDate() {
            return this.date.toISOString().split('T')[0];
        },
        isSetAssist(id){
            for (const student of this.dataAssists) {
                if (student.id == id) {
                    return true;
                }
            }
            return false;
        },
        getStudentAssist(id){
            for (const student of this.dataAssists) {
                if (student.id == id) {
                    return student;
                }
            }
            return null;
        },
        deleteAssist(id){
            for (const key in this.dataAssists) {
                console.log(this.dataAssists[key]);
                if (this.dataAssists[key].id == id) {
                    return this.dataAssists.splice(key, 1);
                }
            }
        },
        postAssists(){
            this.axios.post(`http://127.0.0.1:8000/api/assists`,{
                date: this.mysqlDate(),
                data: this.dataAssists
            }).then((response) => {
                console.log(response);
            });
        }
    },
}
</script>

<template>
    <div class="container">

        <h1>Select date</h1>
        <Datepicker v-model="date" date-picker @update:modelValue="getAssists()"></Datepicker>

        <div v-if="dataStudents != []">
            <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>First name</th>
                        <th>Las name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in dataStudents" :key="item.id">
                        <td>{{ item.student_id }}</td>
                        <td>{{ item.first_name }}</td>
                        <td>{{ item.last_name }}</td>
                        <td>{{ item.email }}</td>
                        <td v-if="!isSetAssist(item.id)">
                            <button type="button" class="btn btn-primary" @click="setAssist(item.id, 'present')">Present</button>
                            <button type="button" class="btn btn-danger" @click="setAssist(item.id, 'absent')">Absent</button>
                        </td>
                        <td v-else>
                            <span><strong>{{ getStudentAssist(item.id).status.toUpperCase() }}</strong></span>
                            <button type="button" class="btn btn-secondary float-right" @click="deleteAssist(item.id)">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <button type="button" class="btn btn-success btn-lg btn-block" @click="postAssists()">Save</button>
        </div>

    </div>
</template>

<style>
.btn {
    margin-right: 10px !important;
}
.btn-block{
    width: 100%;
    margin-bottom: 100px;
}
.float-right{
    float: right;
}
</style>