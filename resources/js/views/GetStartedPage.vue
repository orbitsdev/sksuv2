<template>
  <div class="bg-white">
    <header>
      <Popover class="relative bg-white">
        <div
          class="mx-auto flex max-w-7xl items-center justify-between px-4 py-6 sm:px-6 md:justify-start md:space-x-10 lg:px-8"
        >
          <div class="flex justify-start lg:w-0 lg:flex-1">
            <a href="#">
              <span class="sr-only">Your Company</span>
              <img
                class="h-8 w-auto sm:h-10"
                src="https://tailwindui.com/img/logos/mark.svg?color=green&shade=600"
                alt=""
              />
            </a>
          </div>
          <div class="-my-2 -mr-2 md:hidden">
            <PopoverButton
              class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500"
            >
              <span class="sr-only">Open menu</span>
              <Bars3Icon class="h-6 w-6" aria-hidden="true" />
            </PopoverButton>
          </div>

          <div class="hidden items-center justify-end md:flex md:flex-1 lg:w-0">
            <!-- <flyoutMenu/> -->
            <!-- <BaseSpinner /> -->
            <!-- <a href="#"
              class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900"  >
              Sign in</a> -->

            <!-- <w-confirm class="ml-8 inline-flex items-center justify-center whitespace-nowrap rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700" tooltip="Delete this?">
              Delete
            </w-confirm> -->

            <!-- <router-link  class="ml-8 inline-flex items-center justify-center whitespace-nowrap rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700"> 
              Signup
            </router-link> -->
            <SquareButton @click="showTheForm('login')"> Sign up</SquareButton>
          </div>
        </div>

        <transition
          enter-active-class="duration-200 ease-out"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
          leave-active-class="duration-100 ease-in"
          leave-from-class="opacity-100 scale-100"
          leave-to-class="opacity-0 scale-95"
        >
          <PopoverPanel
            focus
            class="absolute inset-x-0 top-0 z-30 origin-top-right transform p-2 transition md:hidden"
          >
            <div
              class="divide-y-2 divide-gray-50 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5"
            >
              <div class="px-5 pt-5 pb-6">
                <div class="flex items-center justify-between">
                  <div>
                    <img
                      class="h-8 w-auto"
                      src="https://tailwindui.com/img/logos/mark.svg?color=green&shade=600"
                      alt="Your Company"
                    />
                  </div>
                  <div class="-mr-2">
                    <PopoverButton
                      class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500"
                    >
                      <span class="sr-only">Close menu</span>
                      <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                    </PopoverButton>
                  </div>
                </div>
              </div>
              <div class="py-6 px-5">
                <div class="grid grid-cols-2 gap-4">
                  <a
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    class="text-base font-medium text-gray-900 hover:text-gray-700"
                    >{{ item.name }}</a
                  >
                </div>
                <div class="mt-6">
                  <a
                    href="#"
                    class="flex w-full items-center justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-green-700"
                    >Sign up</a
                  >
                  <p class="mt-6 text-center text-base font-medium text-gray-500">
                    Existing customer?
                    <a href="#" class="text-gray-900">Sign in</a>
                  </p>
                </div>
              </div>
            </div>
          </PopoverPanel>
        </transition>
      </Popover>
    </header>

    <main>
      <div>
        <!-- Hero card -->
        <div class="relative">
          <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gray-100" />
          <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="relative shadow-xl sm:overflow-hidden sm:rounded-2xl">
              <div class="absolute inset-0">
                <img
                  class="h-full w-full object-cover"
                  src="/assets/sksu.jpg"
                  alt="People working on laptops"
                />
                <div class="absolute inset-0 bg-green-700 mix-blend-multiply" />
              </div>
              <div class="relative px-4 py-16 sm:px-6 sm:py-24 lg:py-32 lg:px-8">
                <h1
                  class="text-center text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl"
                >
                  <span class="block text-white">SKSU </span>
                  <span class="block text-green-200">Repository Management System</span>
                </h1>
                <!-- <p class="mx-auto mt-6 max-w-lg text-center text-xl text-green-200 sm:max-w-3xl">We Made it Easy </p> -->
                <div
                  class="mx-auto mt-10 max-w-sm sm:flex sm:max-w-none sm:justify-center"
                >
                  <div
                    class="space-y-4 sm:mx-auto sm:inline-grid sm:grid-cols-1 sm:gap-5 sm:space-y-0"
                  >
                    <!-- <a href="#" class="flex items-center justify-center rounded-md border border-transparent bg-white px-4 py-3 text-base font-medium text-green-700 shadow-sm hover:bg-green-50 sm:px-8">Get started</a> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Logo cloud -->
        <div class="bg-gray-100 py-10"></div>
      </div>

      <!-- More main page content here... -->
    </main>


    <!-- LOGIN DIALOG-->
    
    <teleport to="#app" v-if="(showForm == 'login')" >
      <BaseDialog
      :show="showTheForm"
        @close="closeTheForm"
        :width="'400'"
        :transition="'slide-fade-down'"
      >
        <template #c-content>
          <LoginForm @hasRequestError="showErrorDialog" @close="closeTheForm" @showRegister="showTheForm('register')"/>
        </template>
        <template #c-actions> </template>
      </BaseDialog>
    </teleport>
    <teleport to="#app" v-if="(showForm == 'register')">
      <BaseDialog
      :show="show"
        @close="closeTheForm"
        :width="'400'"
        :transition="'scale'"
      >
        <template #c-content>
          <RegisterForm @hasRequestError="showErrorDialog" @close="closeTheForm" @showLogin="showTheForm('login')"/>
        </template>
        <template #c-actions> </template>
      </BaseDialog>
    </teleport>
    
    <!-- REGISTER DIALOG-->


    <!-- ERROR DIALOG -->
    <teleport to="#app">
      <BaseErrorDialog
        :show="requestError != null"
        :width="'400'"
        :transition="'slide-fade-down'"
      >
        <template #c-content>
          <RequestError
            :statusCode="requestError.statusCode"
            @close="closeErrorDialog"
            :message="requestError.message"
          />
        </template>
        <template #c-actions> </template>
      </BaseErrorDialog>
    </teleport>
  </div>

</template>

<script>
import LoginForm from "../components/LoginForm.vue";
import RegisterForm from "../components/RegisterForm.vue";

export default {
  components: {
    LoginForm,
    RegisterForm,
  },
  
    mounted () {
      if(this.$route.query.login =='attemp'){
          this.showTheForm('login');
      }
    },
  data() {
    return {
      showForm: null,
      requestError: null,
    };
  },
  methods: {
    showTheForm(type){
      this.showForm = type;
    },

    closeTheForm() {
      this.showForm = null;
    },

    closeErrorDialog() {
      this.requestError = null;
    },

    showErrorDialog(error) {
      this.requestError = error;
    },
  },
};
</script>

<script setup>
import { Popover, PopoverButton, PopoverGroup, PopoverPanel } from "@headlessui/vue";
import {
  Bars3Icon,
  ChatBubbleBottomCenterTextIcon,
  ChatBubbleLeftRightIcon,
  InboxIcon,
  QuestionMarkCircleIcon,
  XMarkIcon,
} from "@heroicons/vue/24/outline";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";

const solutions = [
  {
    name: "Inbox",
    description: "Get a better understanding of where your traffic is coming from.",
    href: "#",
    icon: InboxIcon,
  },
  {
    name: "Messaging",
    description: "Speak directly to your customers in a more meaningful way.",
    href: "#",
    icon: ChatBubbleBottomCenterTextIcon,
  },
  {
    name: "Live Chat",
    description: "Your customers' data will be safe and secure.",
    href: "#",
    icon: ChatBubbleLeftRightIcon,
  },
  {
    name: "Knowledge Base",
    description: "Connect with third-party tools that you're already using.",
    href: "#",
    icon: QuestionMarkCircleIcon,
  },
];
const navigation = [
  { name: "Pricing", href: "#" },
  { name: "Partners", href: "#" },
  { name: "Company", href: "#" },
];
</script>
