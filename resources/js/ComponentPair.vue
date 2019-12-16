<template>
    <div class="container-fluid">

        <div class="form-row justify-content-center">

            <div class="form-group col-sm-6">
                <label class="font-weight-bold">Choose a Cohort: </label>
                <select v-model="send.cohort" v-for="cohort in cohorts" :key="cohort.id" class="form-control" name="" id="" @change="onCohort()">
                    <option value="">~ Select a Cohort ~</option>
                    <option :value="cohort.id">{{ cohort.name }}</option>
                </select>
            </div>

        </div>


        <div class="form-row mt-5" v-show="showOthers">

            <div class="form-group radio col-sm-6">
                <label class="font-weight-bold">Choose a Topic: </label>
                <div v-for="topic in topics" :key="topic.id" >
                    <input class="" v-model="send.topic" type="radio" name="" :value="topic.id" id=""> {{ topic.title }}
                </div>
            </div>


            <div class="tw-container tw-md:p-5 tw-p-2 mt-3 tw-flex tw-items-center tw-justify-between tw-bg-gray-200">

                <div class="tw-w-full tw-max-w-xs text-center">
                    <draggable tag="ul"
                                group="students"
                            ghost-class="tw-moving-card"
                            :list="students"
                            :animation="200"
                            :move="checkMove">
                        <student v-for="student in students"
                                :student="student"
                                :key="student.id">
                        </student>
                    </draggable>
                </div>


                <div class="tw-w-full tw-max-w-xs text-center">
                    <p class="mb-2 tw-text-gray-700 tw-font-semibold tw-font-sans tw-tracking-wide">Pairing Pool</p>
                    <draggable tag="ul" class="tw-border tw-p-3"
                                group="students"
                            ghost-class="tw-moving-card"
                            :list="pairs"
                            :animation="200">
                        <student v-for="pair in pairs"
                                :student="pair"
                                :key="pair.id">
                        </student>
                    </draggable>
                    <button class="btn btn-primary" @click="mapPair" v-show="this.pairs">PAIR</button>
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
                isValid: true,
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
            showPairButton(){
                if(this.showOthers){
                    if(this.pairs.lenght > 1){
                        return true;
                    }
                    else{
                        return false;
                    }
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
                axios.post('/api/mapPair',{
                    'pairs': this.pairs
                })
                .then(res => {
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

