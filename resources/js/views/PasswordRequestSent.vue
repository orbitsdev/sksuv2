<template>
    <div class="flex h-screen flex-col bg-white">
        <main
          class="mx-auto flex w-full max-w-7xl flex-grow flex-col justify-center px-4 sm:px-6 lg:px-8"
        >
          <div class="flex flex-shrink-0 justify-center">
            <a href="/" class="inline-flex">
              <span class="sr-only">Your Company</span>
              <img class="sv-image" src="/assets/email-sent.svg" alt="sksu" />
            </a>
          </div>
          <div class="py-4">
            <div class="text-center">
                <h1 class="mt-2 text-lg tex-green-400 font-bold  text-gray-900 sm:text-3xl">
                        Succesfully Sent
                           </h1>
              <h1 class="mt-2 text-lg tex-green-400 font-bold tracking-tight text-gray-900 sm:text-lg">
                Go to your email account and click the url to change password {{  this.$route.query.email }}
                         </h1>
              <div class="mt-3 ">
                
                 
                <a
                  href="/"
                  class="text-base font-medium text-indigo-600 hover:text-indigo-500"
                >
                  Go back home
                  <span aria-hidden="true"> &rarr;</span>
                </a>
              </div>
            </div>
          </div>
        </main>
      </div>
</template>

<script>
    export default {
        
    }
</script>

<style scoped>

.sv-image{
    width: 260px;
    height: auto;
}

</style>