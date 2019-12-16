<template>
    <li class="p-4 mb-3 tw-bg-white tw-shadow tw-rounded-lg tw-cursor-move">
        <div class="text-left">
            <p class="tw-m-0 tw-text-gray-700 tw-font-semibold tw-font-sans tw-tracking-wide">{{student.firstname}} {{student.lastname}}</p>
        </div>
    </li>
</template>

<script>
  import { EditIcon, Trash2Icon } from "vue-feather-icons";
  export default {
      name: "student",
    components: {
      EditIcon,
      Trash2Icon
    },
    props: {
      student: {
        type: Object,
        default: () => ({})
      }
    },
  }
</script>
