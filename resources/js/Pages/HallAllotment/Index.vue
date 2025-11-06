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
                        <button type="button" class="btn btn-primary my-1 me-3" @click="printInvoice">Print </button>
                        <!--begin::Add Permission-->
                        <Link v-if="checkPermission('can-create-hall')" :href="route('hall-allotments.create')" class="btn btn-primary my-1">
                            <KTIcon icon-name="plus" icon-class="fs-2" />
                            Add Hall Allotment
                        </Link>
                        <!--end::Add Permission-->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>

            <div class="fw-bold fs-2 mb-6 position-relative print" id="invoice-content">
                <div class="logo-wrapper position-absolute">
                    <img
                        alt="Logo"
                        :src="getAssetPath('/media/logos/jkkniu-logo.png')"
                        class="h-50px"
                    />
                </div>
                <div class="text-center">
                    <h1 class="mb-2">{{ props.hallAllotments[0]?.hall?.name }}</h1>
                    <h4 class="mb-2">JKKNIU, Trishal, Mymensingh</h4>
                </div>
            </div>

            <div class="card-body pt-0" id="invoice-content">
                <Datatable @on-sort="sortData" :data="tableData" :header="tableHeader" :enable-items-per-page-dropdown="true" :checkbox-enabled="false">
                    <!-- Serial Number -->
                    <template v-slot:serial_number="{ row: hallAllotment }">
                        {{ hallAllotment.serial_number }}
                    </template>

                     <!-- Allotment Id -->
                    <template v-slot:id="{ row: hallAllotment }">
                        {{ hallAllotment.id }}
                    </template>

                    <!-- Student ROLL -->
                    <template v-slot:student_roll="{ row: hallAllotment }">
                        {{ hallAllotment.student_roll }}
                    </template>

                    <!-- Student Name -->
                    <template v-slot:student_name="{ row: hallAllotment }">
                        {{ hallAllotment.student_name }}
                    </template>

                    <!-- Hall Name -->
                    <!-- <template v-slot:hall_name="{ row: hallAllotment }">
                        {{ hallAllotment.hall_name }}
                    </template> -->

                    <!-- Seat Code -->
                    <template v-slot:seat_code="{ row: hallAllotment }">
                        {{ hallAllotment.seat_code }}
                    </template>

                    <!-- Starting Month -->
                    <template v-slot:starting_month="{ row: hallAllotment }">
                        {{ formatStartingMonth(hallAllotment.starting_month) }}
                    </template>

                     <!-- Allotment Date -->
                    <template v-slot:allotment_date="{ row: hallAllotment }">
                        {{ hallAllotment.allotment_date }}
                    </template>

                    <!-- Starting Month -->
                    <template v-slot:comment="{ row: hallAllotment }">
                        {{ hallAllotment.comment }}
                    </template>

                    <template v-slot:actions="{ row: hallAllotment }">
                        <div class="d-flex align-items-center justify-content-end no-print">
                            <Link v-if="checkPermission('can-edit-hall-allotment')" :href="route('hall-allotments.edit', hallAllotment.id)" class="btn btn-icon btn-flex btn-active-light-primary w-30px h-30px" data-bs-toggle="tooltip" :title="$t('tooltip.title.edit')">
                                <KTIcon icon-name="pencil" icon-class="fs-3 text-primary" />
                            </Link>
                            <!-- Delete -->
                            <DeleteConfirmationButton v-if="checkPermission('can-delete-hall-allotment')" iconClass="fs-2" :obj="hallAllotment" confirmRoute="hall-allotments.destroy" title="Delete hall" :messageTitle="`${hallAllotment.student_name} hall allotment cancel?`"/>
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
import { getAssetPath } from "@/Core/helpers/Assets";
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
console.log(props.hallAllotments);

interface Breadcrumb {
    url: string;
    title: string;
}

interface IHallAllotment {
    id: number;
    student_roll: number;
    student_name: string;
    hall_name: string;
    student?: IStudent;
    hall?: IHall;
    seat_code?: string;
    starting_month?: string;
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
        columnName: 'SL',
        columnLabel: "serial_number",
        sortEnabled: false,
        columnWidth: 50
    },
    {
        columnName: 'Allotment ID',
        columnLabel: "id",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: 'Student Roll',
        columnLabel: "student_roll",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: 'Student Name',
        columnLabel: "student_name",
        sortEnabled: true,
        columnWidth: 200
    },
    {
        columnName: 'Seat Number',
        columnLabel: "seat_code",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: 'Starting Month',
        columnLabel: "starting_month",
        sortEnabled: true,
        columnWidth: 150
    },
    {
        columnName: 'Allotment Date',
        columnLabel: "allotment_date",
        sortEnabled: true,
        columnWidth: 100
    },
    {
        columnName: 'Comment',
        columnLabel: "comment",
        sortEnabled: true,
        columnWidth: 150
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
        let serial_number = 0;
        initHallAllotments.value = props.hallAllotments.map((allotment: any) => ({
            id: allotment.id,
            serial_number: ++serial_number,
            student_roll: allotment.student?.roll || '',
            student_name: allotment.student?.name || '',
            hall_name: allotment.hall?.name || '',
            seat_code: allotment.seat?.seat_code || '',
            starting_month: allotment.starting_month || '',
            starting_month: allotment.starting_month || '',
            allotment_date: allotment?.allotment_date || '',
            comment: allotment?.comment || ''
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
const formatStartingMonth = (date: string) => {
    if (!date) return '';
    const [year, month] = date.split('-');
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const monthIndex = parseInt(month) - 1;
    return `${monthNames[monthIndex]}/${year}`;
};

const printInvoice = () => {
    document.title = `Hall Allotment`;
    window.print();
};
</script>

<style>
    #print-only{
        display: none;
    }

    .print{
        display: none !important;
    }

    .logo-wrapper {
        display: flex;
        align-items: center;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
    }

    .logo-wrapper img {
        object-fit: contain;
        height: 50px;
    }

    #invoice-content {
        min-height: 80px;
    }

    @media print {
        @page {
            margin-left: 0.5cm !important;
            margin-right: 0.5cm !important;
            /* size: landscape; */
        }

        html,body * {
            visibility: hidden;
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
        }

        /* For second page don't show the heading again */
        thead {
            display: table-row-group !important;
        }

        .card-body, .app-container, .app-content, #kt_app_content {
            margin-top: -45px !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: none !important;
        }

        .card-header{
            margin-top: -3rem;
        }

        #invoice-content {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        #invoice-content, #invoice-content * {
            visibility: visible !important;
        }

        .logo-wrapper img {
            visibility: visible !important;
            height: 50px !important;
            width: auto !important;
        }

        #no-print {
            display: none !important;
        }

        .no-print {
            display: none !important;
        }

        .print{
            display: block !important;
        }

        #print-only{
            display: block;
        }

        .table {
            page-break-inside: auto;
            border-collapse: collapse !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            table-layout: fixed !important;
        }

        .table th,
        .table td {
            border: 0.2px solid #9291914f !important;
            padding: 2px 10px !important;
            text-align: center !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            font-size: 12px !important;
        }

        .table:not(.table-bordered) tfoot tr:last-child,
        .table:not(.table-bordered) tbody tr:last-child {
            border-bottom: 0.2px solid #9291914f !important;
        }

        table th:last-child,
        table td:last-child {
            display: none !important;
        }

        .ledgerTable table th:last-child,
        .ledgerTable table td:last-child {
            display: block !important;
        }
    }
</style>
