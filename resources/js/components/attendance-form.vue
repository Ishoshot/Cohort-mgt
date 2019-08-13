<template>

	<div>

		<el-main>
        <div class="row justify-content-center" style="margin-top:6%;">
          	
            <div class="jumbotron col-md-6">
            
            <form @submit.prevent="submit">
    
            <div class="mb-4">
            	<h3>Complete to Take Attendance</h3>
            </div>

                <div v-if="message" class="text-danger">
                  <div class="alert alert-danger alert-dismissible fade show text-justify" role="alert">
                    {{ message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>

                <div v-if="success" class="text-white">
                  <div class="alert alert-success alert-dismissible fade show text-justify" role="alert">
                    {{ success }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>


            
	            <div class="form-group mt-4">
	            	<el-input class="col-md-12 p-0" placeholder="Please enter your Username" name="username" suffix-icon="el-icon-user" id="username" v-model="username" clearable>
                </el-input>
                <div v-if="errors && errors.username[0]" class="text-danger">{{ errors.username[0] }}</div>
	            </div>
          
              <div class="form-group mt-4">
                <el-select class="col-md-12 p-0" placeholder="Select Cohort" v-model="cohort" 
                name="cohort" id="cohort" clearable>
                  <el-option
                    v-for="cohort in cohorts"
                    :key="cohort.id"
                    :label="cohort.name"
                    :value="cohort.id">
                  </el-option>
                 </el-select>
                 <div v-if="errors && errors.cohort[0]" class="text-danger">{{ errors.cohort[0] }}</div>
              </div>

	            <div class="form-group d-flex mt-5 justify-content-between">
                <input type="reset" class="btn btn-danger" value="Reset">
	              <button type="submit" class="btn btn-primary">Take Attendance</button>
	            </div>
                
          
          </form>
          
          </div>
        
        </div>
    
    </el-main>
	
  </div>

</template>


<style type="text/css" media="screen">

.jumbotron{
	background-color:rgba(225,225,225,0);
	box-shadow: 0px 1px 4px 0px rgba(0,0,0,0.5);
}
	
</style>

<script>
export default {
  data() {
    return {
      cohorts:[],
      message: '',
      success: '',
      username: '',
      cohort: '',
      errors:{
        username:[],
        cohort:[]
      },
    }
  },

  created(){
  	this.fetchCohorts();
  },

  methods:{
  	
    fetchCohorts(){
  		fetch('api/cohorts')
  		.then(res => res.json())
  		.then(res => {
        // console.log(res.data);
  			this.cohorts = res.data;
  		});
    },

    validate(){
      let isValid = true;
      if(this.username.trim() == ''){
        this.errors.username.push("Username is required");
        isValid = false;
      }
      if(this.cohort.trim() == ''){
        this.errors.cohort.push("Please select a cohort");
        isValid = false;
      }
      return isValid;
    },


    submit() {
      // this.errors = {};
      // if(this.validate()){
      axios.post('/api/submit',{
          'username': this.username,
          'cohort': this.cohort
      })
      .then(res => {
          console.log(res.data);
          if(res.data.message){
              this.message = (res.data['message']);
              this.success = '';
          }
          if(res.data.success){
              this.success = (res.data['success']);
              this.message = '';
          }
          this.username = '';
          this.cohort = '';
      })
      .catch(error => {
        if (error.response.status === 422) {
          this.errors = error.response.data.errors || {};
          this.username = '';
          this.cohort = '';
        }
      });

      // }
      
    },


  }

}; 
</script>
