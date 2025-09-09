<template>
    <AuthenticatedLayout :breadcrumbs="props?.breadcrumbs" :pageTitle="props?.pageTitle">

        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <KTIcon icon-name="magnifier" icon-class="fs-1 position-absolute ms-6" />
                        <input type="text" v-model="search" @input="searchData()" class="form-control form-control-solid w-250px ps-15" placeholder="Search Hall Allotment" />
                    </div>
                    <!--end::Search-->
                </div>

                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Add Permission-->
                        <Link v-if="checkPermission('can-create-hall')" :href="route('hall-allotments.create')" class="btn btn-primary">
                            <KTIcon icon-name="plus" icon-class="fs-2" />
                            Add Hall Allotment
                        </Link>
                        <!--end::Add Permission-->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>

            <div class="card-body pt-0">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                    <!-- Student ROLL -->
                     <template v-slot:student_roll="{ row: hallAllotment }">
                        {{ hallAllotment.student_roll }}
                    </template>

                    <!-- Student Name -->
                    <template v-slot:student_name="{ row: hallAllotment }">
                        {{ hallAllotment.student_name }}
                    </template>

                    <!-- Hall Name -->
                    <template v-slot:hall_name="{ row: hallAllotment }">
                        {{ hallAllotment.hall_name }}
                    </template>

                    <!-- Seat Code -->
                    <template v-slot:seat_code="{ row: hallAllotment }">
                        {{ hallAllotment.seat_code }}
                    </template>

                    <template v-slot:actions="{ row: hallAllotment }">
                        <div class="d-flex align-items-center justify-content-end">
                            <Link v-if="checkPermission('can-edit-hall-allotment')" :href="route('hall-allotments.edit', hallAllotment.id)" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px" data-bs-toggle="tooltip" :title="$t('tooltip.title.edit')">
                                <KTIcon icon-name="pencil" icon-class="fs-3 text-primary" />
                            </Link>
                            <!-- Delete -->
                            <DeleteConfirmationButton v-if="checkPermission('can-delete-hall-allotment')" iconClass="fs-2" :obj="hallAllotment" confirmRoute="hall-allotments.destroy" title="Delete hall" :messageTitle="`${hallAllotment.student_name} hall allotment?`"/>
                        </div>
                    </template>
                </Datatable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted,defineProps } from 'vue';
import Datatable from "@/Components/kt-datatable/KTDataTable.vue";
import type { Sort } from "@/Components/kt-datatable/table-partials/Models";
import { MenuComponent } from "@/Assets/ts/components";
import arraySort from "array-sort";
import { Link } from '@inertiajs/vue3';
import KTIcon from "@/Core/helpers/kt-icon/KTIcon.vue";
import { checkPermission } from "@/Core/helpers/Permission";
import i18n from '@/Core/plugins/i18n';
import ChangeStatusButton from '@/Components/Button/ChangeStatusButton.vue';
import DeleteConfirmationButton from '@/Components/Button/DeleteConfirmationButton.vue';

const { t } = i18n.global;

const props = defineProps({
    hallAllotments: Object as() => IHallAllotment[] | undefined,
    breadcrumbs: Array as() => Breadcrumb[],
    pageTitle: String,
});

interface Breadcrumb {
    url: string;
    title: string;
}

interface IHallAllotment {
    id: number;
    student_roll: number;
    student_name: string;
    hall_name: string;
    is_approved: boolean;
    is_active: boolean;
    student?: IStudent;
    hall?: IHall;
}

interface IStudent {
    id: number;
    name: string;
    roll: string;
}

interface IHall {
    id: number;
    name: string;
}

const tableHeader = ref([
    {
        columnName: 'Student Roll',
        columnLabel: "student_roll",
        sortEnabled: true,
        columnWidth: 150
    },
    {
        columnName: 'Student Name',
        columnLabel: "student_name",
        sortEnabled: true,
        columnWidth: 200
    },
    {
        columnName: 'Hall Name',
        columnLabel: "hall_name",
        sortEnabled: true,
        columnWidth: 200
    },
    {
        columnName: 'Seat Number',
        columnLabel: "seat_code",
        sortEnabled: true,
        columnWidth: 200
    },
    {
        columnName: 'Action',
        columnLabel: "actions",
        sortEnabled: true,
        columnWidth: 100
    },
]);

const tableData = ref < IHallAllotment[] > ([]);
const initHallAllotments = ref < IHallAllotment[] > ([]);

onMounted(() => {
    if (props.hallAllotments) {
        initHallAllotments.value = props.hallAllotments.map((allotment: any) => ({
            id: allotment.id,
            student_roll: allotment.student?.roll,
            student_name: allotment.student?.name,
            hall_name: allotment.hall?.name,
            seat_code: allotment.seat?.seat_code,
        }));
        tableData.value = initHallAllotments.value;
    }
});

const search = ref < string > ("");
const searchData = () => {
    tableData.value = [...initHallAllotments.value];
    if (search.value !== "") {
        tableData.value = tableData.value.filter(item => searchingFunc(item, search.value));
    }
    MenuComponent.reinitialization();
};

const searchingFunc = (obj: any, value: string): boolean => {
    for (let key in obj) {
        if (!Number.isInteger(obj[key]) && !(typeof obj[key] === "object")) {
            if (obj[key] && obj[key].includes && obj[key].includes(value)) {
                return true;
            }
        }
    }
    return false;
};

const sortData = (sort: Sort) => {
    const reverse: boolean = sort.order === "asc";
    if (sort.label) {
        arraySort(tableData.value, sort.label, {
            reverse
        });
    }
};
</script>
