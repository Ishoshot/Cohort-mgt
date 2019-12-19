<template>
<div>

    <div class="container-fluid p-2" @click="clearPairMessage">


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

        <vcl-code rows="6" secondary="#e8e8e8" primary="#e8ecf1" class="mt-5" v-if="loading"></vcl-code>


        <div class="mt-5 p-2" v-show="showOthers">


            <draggable tag="div" class="tw-border row tw-md:p-5 tw-p-2 tw-bg-gray-200 text-center"
                    group="students"
                    ghost-class="tw-moving-card"
                    :list="students"
                    :animation="200"
                    :move="checkMove" @end="maxPair" @start="clearPairMessage">
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
                        :animation="200" @start="clearPairMessage">
                    <pair-pool v-for="pair in pairs"
                            :student="pair"
                            :key="pair.id">
                    </pair-pool>
                </draggable>

                <button class="mt-3 btn btn-primary rounded" @click="mapPair" :disabled="this.pairs.length < 2 || this.send.topic == '' ">PAIR</button>

                <div v-if="pairMessage" style="position:absolute; top:35px; left:0px; width:100%;">
                    <div class="alert alert-warning alert-dismissible fade show text-justify" role="alert">
                    {{ pairMessage }}
                    <span class="tw-cursor-pointer badge badge-pill badge-dark" @click="showAgain = false">Don't Show this Again</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                </div>

            </div>



            <div class="radio col-sm-6 mt-5">
                <label class="font-weight-bold">Choose a Topic: </label>
                <div v-for="topic in topics" :key="topic.id" >
                    <input @click="clearPairMessage" class="topic-radio mb-1" v-model="send.topic" checked="checked" type="radio" name="" :value="topic.id" id=""> {{ topic.title }}
                </div>
            </div>


        </div>


    </div>

</div>
</template>


<script>
import draggable from 'vuedraggable';
import student from './Students.vue';
import { VclCode } from 'vue-content-loading';

    export default {
        name: "component-pair",

        components: {
            draggable,
            VclCode,
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
                loading: false,
                showAgain: true,
                message: '',
                success: '',
                pairMessage: '',
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

            clearPairMessage(){
                if(this.pairMessage.length > 1){
                    this.pairMessage = "";
                }
            },

            maxPair(){
                if(this.showAgain && this.pairs.length > 1){
                    this.pairMessage = "Maximum of 2 [two] Students are required for Pairing. Don't forget to Choose a topic";
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
                    this.showOthers = false;
                    this.loading = true;
                    this.message = '';
                    this.success = '';
                    // this.getPairedStudents();
                    setTimeout(()=>{
                        axios.post('/api/getdata',{
                            'cohort': this.send.cohort
                        })
                        .then(res => {
                            this.loading = false;
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
                    }, 1000);
                }
                else
                {
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

