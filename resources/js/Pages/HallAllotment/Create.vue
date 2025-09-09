<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header border-0 cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">{{ props.hallAllotment?.id ? 'Edit Hall Allotment' : 'Add Hall Allotment' }}</h3>
                </div>
                <div class="d-flex justify-content-end p-4" data-kt-customer-table-toolbar="base">
                    <button v-if="checkPermission('can-create-student')" type="button" class="btn btn-primary px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_add_student" style="width:150px">
                        <KTIcon icon-name="plus" icon-class="fs-2"/>
                        Add Student
                    </button>
                </div>
            </div>
            <!--end::Card header-->

            <div class="show">
                <VForm @submit="submit()" class="form">
                    <!--begin::Card body-->
                    <div class="card-body border-top p-9">
                        <!-- Student Name -->
                        <div class="row mb-2 g-4">
                            <div class="col-md-6 fv-row">
                                <div class="d-flex flex-column mb-5 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Student Roll</label>
                                    <Multiselect
                                        placeholder="Select Student Roll"
                                        v-model="formData.student_id"
                                        :searchable="true"
                                        :options="allStudents"
                                        label="roll"
                                        trackBy="roll"
                                        :disabled="!!props.hallAllotment?.id"
                                    />
                                    <ErrorMessage :errorMessage="formData.errors.student_id" />
                                </div>
                            </div>

                            <div class="col-md-6 fv-row">
                                <div class="d-flex flex-column mb-5 fv-row">
                                    <label class="fs-5 fw-semibold mb-2">Student Name</label>
                                    <Field type="text" class="form-control form-control-lg form-control-solid" placeholder="Student Name" name="student_name" v-model="formData.student_name" disabled/>
                                </div>
                            </div>
                        </div>

                        <!-- Hall Name -->
                        <div class="row mb-2 g-4">
                            <div class="col-md-6 fv-row">
                                <div class="d-flex flex-column mb-5 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Hall Name</label>
                                    <Multiselect
                                        placeholder="Select Student"
                                        v-model="formData.hall_id"
                                        :searchable="true"
                                        :options="allHalls"
                                        label="name"
                                        trackBy="name"
                                    />
                                    <ErrorMessage :errorMessage="formData.errors.hall_id" />
                                </div>
                            </div>

                            <div class="col-md-6 fv-row">
                                <div class="d-flex flex-column mb-5 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2"> Seat Number </label>
                                    <Multiselect
                                        placeholder="Select Seat Number"
                                        v-model="formData.seat_id"
                                        :searchable="true"
                                        :options="allSeats"
                                        label="code"
                                        trackBy="code"
                                    />
                                    <ErrorMessage :errorMessage="formData.errors.seat_id" />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2 g-4">
                            <div class="col-md-12 fv-row">
                                <div class="d-flex flex-column mb-5 fv-row">
                                    <label class="required fs-5 fw-semibold mb-2">Allotment Date</label>
                                    <Field type="date" class="form-control form-control-lg form-control-solid" placeholder="Allotment Date" name="allotment_date" v-model="formData.allotment_date"/>
                                    <ErrorMessage :errorMessage="formData.errors.allotment_date" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card body-->

                    <!-- Submit Button-->
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <SubmitButton :id="props.hallAllotment?.id" />
                    </div>
                </VForm>
            </div>
        </div>
        <AddStudentModal :allDepartments="allDepartments"/>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Field, Form as VForm } from "vee-validate";
import { useForm } from '@inertiajs/vue3';
import ErrorMessage from "@/Components/Message/ErrorMessage.vue";
import SubmitButton from "@/Components/Button/SubmitButton.vue";
import Multiselect from '@vueform/multiselect';
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { checkPermission } from "@/Core/helpers/Permission";
import { ref, watch } from 'vue';
import AddStudentModal from "@/Pages/hallAllotment/Modal/AddStudentModal.vue";

const props = defineProps({
    hallAllotment: Object,
    students: Array as () => IStudent[] | undefined,
    halls: Array,
    departments: Object,
    studentId: Number,
    seats: Object,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

interface IStudent {
    id: number;
    name: string;
    roll: string;
    [key: string]: any;
}

const today = ref(new Date().toISOString().substr(0, 10));

const formData = useForm({
    id: props.hallAllotment?.id || '',
    student_id: props.hallAllotment?.student_id || props.studentId || '',
    hall_id: props.hallAllotment?.hall_id || '',
    seat_id: props.hallAllotment?.seat_id || '',
    allotment_date: props.hallAllotment?.allotment_date || today,
    student_name: props.students?.find((student: any) => student.id === props.hallAllotment?.student_id)?.name || '',
});

const allStudents = ref<Array<any>>([]);
if (Array.isArray(props.students) && props.students.length > 0) {
    allStudents.value = props.students.map((student: any) => ({value: student.id, roll: student.roll, name: student.name}));
}

const allHalls = ref<Array<any>>([]);
if (Array.isArray(props.halls) && props.halls.length > 0) {
    allHalls.value = props.halls.map((hall: any) => ({value: hall.id, name: hall.name}));
}

const allDepartments = ref<Array<any>>([]);
if (Array.isArray(props.departments) && props.departments.length > 0) {
    allDepartments.value = props.departments.map((dept: any) => ({value: dept.id, name: dept.name}));
}

const allSeats = ref<Array<any>>([]);
if (Array.isArray(props.seats) && props.seats.length > 0) {
    allSeats.value = props.seats.map((seat: any) => ({value: seat.id, code: seat.seat_code}));
}

watch(() => formData.student_id, (newId) => {
    const selected = allStudents.value.find((s: any) => s.value === newId);
    formData.student_name = selected ? selected.name : '';
});

const submit = () => {
    if (props.hallAllotment?.id) {
        formData.put(route('hall-allotments.update', props.hallAllotment?.id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log("✅ Hall allotment updated successfully");
            },
            onError: (errors) => {
                console.error("❌ Validation errors on update:", errors);
            },
        });
    } else {
        formData.post(route('hall-allotments.store'), {
            preserveScroll: true,
            onSuccess: () => {
                console.log("✅ Hall allotment created successfully");
            },
            onError: (errors) => {
                console.error("❌ Validation errors on create:", errors);
            },
        });
    }
};

</script>
