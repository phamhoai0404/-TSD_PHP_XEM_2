<template>
    <div id="assign_micropc">
        <fieldset>
            <legend>{{ $t('message.line.micropc_line') }}</legend>
            <v-container fluid style="padding-top: 10px;">
                <div v-if='dataLine.user'>{{ $t('message.line.department') }}:
                    <span v-if='dataLine.user.department'>{{ dataLine.user.department.depCode }}</span>
                </div>
                <div v-if='dataLine.lineCode'>{{ $t('message.line.line') }}:
                    {{ dataLine.lineCode }}
                </div>
                <v-data-table
                    class="list-micro"
                    :rows-per-page-text="$t('message.paginate')"
                    :headers="headers"
                    :items="microPCs"
                    :pagination.sync="pagination"
                    :rows-per-page-items= '[15,25,{"text":"$vuetify.dataIterator.rowsPerPageAll","value":-1}]'
                    >
                    <template slot="headers" slot-scope="props">
                        <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'microCode' == pagination.sortBy ? 'active' : '']" @click="changeSort('microCode')">
                            <v-icon small>arrow_upward</v-icon>{{ $t('message.line.micro_pc') }}
                        </th>
                        <th :class="['column sortable', pagination.descending ? 'desc' : 'asc', 'ipAddress' == pagination.sortBy ? 'active' : '']" @click="changeSort('ipAddress')">
                            <v-icon small>arrow_upward</v-icon>{{ $t('message.line.ip_address') }}
                        </th>
                        <th>{{ $t('message.line.select') }}</th>
                    </template>
                    <template v-slot:items="props">
                        <td class="text-xs-center">{{ props.item.microCode }}</td>
                        <td class="text-xs-center">{{ props.item.ipAddress }}</td>
                        <td style="padding-right: 0px; margin-right: 0px; padding-left: 0px;">
                            <v-checkbox
                            v-model="microPcSelected[props.index]"
                            value="true"
                            @change="checkMicroSelected(props.item, props.index)"
                            :disabled="changeStatusline == 'detail'"
                            style="margin-left: 28px;"
                            hide-details class="shrink">
                            </v-checkbox>
                        </td>
                    </template>
                    <template v-slot:no-data>
                        <td colspan="3" class="text-xs-center">{{ $t('message.no_data_table') }}</td>
                    </template>
                </v-data-table>
            </v-container>
        </fieldset>
    </div>
</template>

<script>
import { getMicroByLineId, getMicrosByDepIdWidthLineIdNull, getMicrosByDepIdWidthLineIdCurrentOrNull } from '../../api/line';
export default {
    name: "MicroPCComponent",
    data() {
        return {
            changeStatusline:'',
            dataLine: {},
            microPCs: [],
            headers: [],
            pagination: {
                sortBy: 'microCode'
            }
        }
    },
    watch: {
        dataDetailLine() {
            this.dataLine = this.dataDetailLine;
        },
        statusLine() {
            this.changeStatusline = this.statusLine;
        },
        departmentId() {
            if(this.$store.state.departmentId != null) {
                this.fetchMicrosByDepIdWidthLineIdNull(this.$store.state.departmentId);
            }
        }
    },
    props: {
        statusLine: {
            type: String,
            default: ''
        },
        dataDetailLine: {
            type: Object,
            default: () => {
                return {};
            }
        },
    },
    computed: {
        microPcSelected () {
            return this.$store.state.microPcSelected;
        },
        microPcs () {
            return this.$store.state.microPcs;
        },
        microPcsWhenUpdate () {
            return this.$store.state.microPcsWhenUpdate;
        },
        departmentId () {
            return this.$store.state.departmentId;
        }
    },
    methods: {
        changeSort (column) {
            if (this.pagination.sortBy == column) {
                this.pagination.descending = !this.pagination.descending
            } else {
                this.pagination.sortBy = column;
                this.pagination.descending = false
            }
        },
        setDataDetail() {
            this.dataLine = this.dataDetailLine;
            this.changeStatus();
        },
        setInitData() {
            this.microPCs = [];
            this.dataLine = {};
            this.$store.state.microPcSelected = [];
            this.$store.state.microPcsWhenUpdate = [];
        },
        changeStatus() {
            this.changeStatusline = this.statusLine;
        },
        fetchMicroByLineId(lineId) {
            getMicroByLineId(lineId)
                .then(response => {
                    this.microPCs = response;
                    for (let index = 0; index < response.length; index++) {
                        if(response[index].lineId) {
                            this.microPcSelected[index] = 'true';
                        } else {
                            this.microPcSelected[index] = null;
                        }
                    }
                }).catch(err => {
                console.log(err);
            })
        },
        fetchMicrosByDepIdWidthLineIdNull(depId) {
            getMicrosByDepIdWidthLineIdNull(depId)
                .then(response => {
                    this.microPCs = response;
                }).catch(err => {
                console.log(err);
            })
        },
        fetchMicrosByDepIdWidthLineIdCurrentOrNull(lineId, depId) {
            getMicrosByDepIdWidthLineIdCurrentOrNull(lineId, depId)
                .then(response => {
                    this.microPCs = response;
                    this.$store.state.microPcsWhenUpdate = response;
                    this.$store.state.responMicroPcsBeforeUpdate = response;
                    for (let index = 0; index < response.length; index++) {
                        if(response[index].lineId) {
                            this.microPcSelected[index] = 'true';
                        } else {
                            this.microPcSelected[index] = null;
                        }
                    }
                }).catch(err => {
                console.log(err);
            })
        },
        checkMicroSelected(value, index) {
            let microPcSelected = this.$store.state.microPcSelected[index];
            if(microPcSelected == 'true') {
                this.microPcs[index] = value;
                this.microPcsWhenUpdate[index] = value;
            } else {
                this.microPcs[index] = {};
                this.microPcsWhenUpdate[index].id = value.id;
            }
        }
    }
}
</script>

<style>
    #assign_micropc table thead {
        background: #ccc !important;
    }

    #assign_micropc {
        margin-top: 10px;
    }

    #assign_micropc table.theme--light thead tr th {
        font-weight: bold;
        color: #000;
        border: 1px solid #000;
        width: auto;
        font-size: 15px;
    }

    #assign_micropc .list-micro td {
        border: 1px solid #000;
    }

    #assign_micropc .list-micro tbody {
        background-color: #fafafa;
    }

    #assign_micropc .list-micro {
        margin-top: 15px;
    }

    #assign_micropc legend {
        margin-left: 20px;
    }

    #assign_micropc #header_micro2 {
        padding: 11px;
    }

    .v-input--selection-controls__input {
        margin-right: 0px !important;
    }
</style>
