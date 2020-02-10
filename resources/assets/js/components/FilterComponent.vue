<template>
    <div class="container">
        <p>{{now}}</p>
        <div class="card-header">
            <select  id="" v-model="sort" @change="sortValue">
                <option value="1" >Active</option>
                <option value="0" >In-Active</option>
            </select>
        </div>

        <div class="card-body">
            <ul v-for="post in post" :key='post.id'>
                <li>{{ post.title }} {{ post.active }} </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props:['post'],
        data(){
            return {
                totallike:'',
                posts:'',
                sort:'',
            }
        },
        methods:{
           loadPost(){
               this.post=this.post
           },
           sortValue(){
               axios.post('/showpost',{sort:this.sort})
               .then(response => (this.post=response.data.post))
           }
        },
        computed:{
            now: function(){
                return Date.now()
            }
        },
        mounted() {
            console.log('console filter componet')
        }
    }
</script>