<template>
    <div class="container-fluid p-2">

        <div v-if="message">
            <div class="alert alert-danger alert-dismissible fade show text-justify" role="alert">
            {{ message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        </div>

        <div v-if="success">
            <div class="alert alert-success alert-dismissible fade show text-justify" role="alert">
            {{ success }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
        </div>

        <div class="row justify-content-center">

            <div class="col-sm-6">
                <label class="font-weight-bold">Choose a Cohort: </label>
                <select v-model="send.cohort" v-for="cohort in cohorts" :key="cohort.id" class="form-control" name="" id="" @change="onCohort()">
                    <option value="">~ Select a Cohort ~</option>
                    <option :value="cohort.id">{{ cohort.name }}</option>
                </select>
            </div>

        </div>


        <div class="mt-5" v-show="showOthers">


            <draggable tag="div"
                    group="students"
                    ghost-class="tw-moving-card"
                    :list="students"
                    :animation="200"
                    :move="checkMove" class="tw-border row tw-md:p-5 tw-p-2 tw-bg-gray-200 text-center">
                <student v-for="student in students"
                        :student="student"
                        :key="student.id">
                </student>
            </draggable>



            <div class="col-sm-6 text-center mt-5">
                <p class="mb-2 tw-text-gray-700 tw-font-semibold tw-font-sans tw-tracking-wide">Pairing Pool</p>

                <draggable tag="div" class="row tw-md:p-5 tw-border tw-p-2 tw-bg-gray-200" style="min-height:100px;"
                            group="students"
                        ghost-class="tw-moving-card"
                        :list="pairs"
                        :animation="200">
                    <pair-pool v-for="pair in pairs"
                            :student="pair"
                            :key="pair.id">
                    </pair-pool>
                </draggable>

                <button class="mt-3 btn btn-primary rounded" @click="mapPair" :disabled="this.pairs.length < 2 || this.send.topic == '' ">PAIR</button>
            </div>



            <div class="radio col-sm-6 mt-5">
                <label class="font-weight-bold">Choose a Topic: </label>
                <div v-for="topic in topics" :key="topic.id" >
                    <input class="topic-radio mb-1" v-model="send.topic" checked="checked" type="radio" name="" :value="topic.id" id=""> {{ topic.title }}
                </div>
            </div>


        </div>


    </div>
</template>


<script>
import draggable from 'vuedraggable';
import student from './Students.vue';

    export default {
        name: "component-pair",

        components: {
            draggable,
        },

        mounted() {
            this.loadCohorts();
        },

        data(){
            return{
                send: {
                    cohort: '',
                    topic: '',
                },
                message: '',
                success: '',
                showOthers: false,
                cohorts:[],
                pairs:[],
                topics:[],
                students:[],
                pairedStudents:[],
                filteredStudents:[]
            }
        },

        computed:{
            filterStudentsAndPair(){
                if(this.showOthers){
                    return this.filteredStudents = this.pairedStudents.filter(x => this.students.includes(x));
                }
            },
        },

        methods:{
            checkMove() {
                if (this.pairs.length >= 2){
                    return false;
                }
            },

            getPairedStudents(){
                axios.post('/api/getPairedStudents',{
                    'cohort': this.send.cohort
                })
                .then(res => {
                    if(res.data.pairedStudents){
                        this.pairedStudents = res.data.pairedStudents;
                    }
                })
                .catch(err => {
                    console.log(err);
                });
            },

            loadCohorts(){
                axios.get('/api/loadCohorts')
                .then(res => {
                    this.cohorts = res.data.cohorts;
                })
                .catch(err => {
                    console.log(err);
                })
            },

            onCohort(){
                if(event.target.value.trim() != ""){
                    this.getPairedStudents();
                    axios.post('/api/getdata',{
                        'cohort': this.send.cohort
                    })
                    .then(res => {
                        if(res.data.topics){
                            this.topics = res.data.topics;
                        }
                        if(res.data.students){
                            this.students = res.data.students;
                        }
                        this.showOthers = true;
                    })
                    .catch(err => {
                        console.log(err);
                    })
                }
                else{
                    return;
                }
            },

            mapPair(){
                this.message = '';
                this.success = '';
                axios.post('/api/mapPair',{
                    'pairs': this.pairs,
                    'cohort_id': this.send.cohort,
                    'topic_id': this.send.topic
                })
                .then(res => {
                    if(res.data.message){
                        this.message = (res.data['message']);
                        this.success = '';
                    }
                    if(res.data.success){
                        this.success = (res.data['success']);
                        this.message = '';
                        this.pairs = [];
                    }
                    console.log(res.data)
                })
                .catch(err => {
                    console.log(err);
                })
            },

        },
    }
</script>

<style lang="css">

.tw-moving-card {
  @apply opacity-50 bg-gray-100 border border-blue-500;
}

</style>

