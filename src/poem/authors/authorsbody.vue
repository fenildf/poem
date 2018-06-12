<template>
  <div>
    <a :href = "'./?name='+author" target="_blank" v-for="author in authors"><span>{{author}}</span></a>
  </div>
</template>

