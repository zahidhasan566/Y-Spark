<template>
    <div class="datatable" v-if="!isLoading">
        <div class="search mb-2">
            <div class="row">
                <div class="col-lg-3">
                    Show <select class="form-control" style="width:unset;display:unset" v-model="showDataAmount" @change="selectedDataAmount" id="rows">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                </select> rows
                </div>
                <div class="col-lg-3"></div>
                <div class="col-lg-3"></div>
                <div class="col-lg-3">
                    <input type="text" style="float:right" class="form-control" placeholder="Search here" id="search" @keyup="search()" v-model="requestParams.search"/>
                </div>
            </div>
        </div>
        <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap dataTable no-footer dtr-inline table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
            <th v-for="(column,columnIndex) in options.columns" class="sorting" :style="{'text-align':column.textAlign}" :key="columnIndex">
                <span>{{ column.title }}</span>
                <span style="float: right" v-if="requestParams.sortedKey === column.key && requestParams.sortedType === 'asc'">
                    <a href="javascript:" @click="sortedKeyValue(column.key,'desc')">
                        <img :src="`${mainOrigin}assets/images/datatable/up.png`" alt="up.png">
                    </a>
                </span>
                <span style="float: right" v-else-if="requestParams.sortedKey === column.key && requestParams.sortedType === 'desc'">
                    <a href="javascript:" @click="sortedKeyValue(column.key,'asc')">
                        <img :src="`${mainOrigin}assets/images/datatable/down.png`" alt="down.png">
                    </a>
                </span>
                <span style="float: right" v-else-if="column.sortable">
                   <a href="javascript:" @click="sortedKeyValue(column.key,'desc')">
                      <img :src="`${mainOrigin}assets/images/datatable/sort.png`" alt="sort.png">
                   </a>
                </span>
            </th>
            </thead>
            <tbody>
            <template v-if="dataSets.length > 0">
                <tr v-for="(data,dataIndex) in dataSets" :key="dataIndex">
                    <td v-for="(column,columnIndex) in options.columns" :key="columnIndex" :style="{'text-align':column.textAlign}">
                        <span v-if="column.type === 'component'">
                            <component :is="column.name" :row="data"></component>
                        </span>
                        <span v-else-if="column.type === 'clickable'">
                          <router-link style="text-decoration: none;color: #007bff !important;" :to="column.source+'/'+data[column.uniqueField]">{{data[column.key] }}</router-link>
                        </span>
                        <span v-else-if="column.numberFormat">
                          {{ numberFormat(data[column.key]) }}
                        </span>
                        <span v-else-if="column.periodFormat">
                           {{ periodFormat(data[column.key]) }}
                        </span>
                        <span v-else-if="column.dateFormat">
                           {{ dateFormat(data[column.key]) }}
                        </span>
                        <span v-else-if="column.type === 'has_child'">
                           {{ data[column.child_name] ? data[column.child_name][column.key] : '' }}
                        </span>
                        <span v-else>
                          {{ data[column.key] }}
                        </span>
                    </td>
                </tr>
            </template>
            <template v-else>
                <tr style="text-align: center;">
                    <td :colspan="options.columns.length"> No data found.</td>
                </tr>
            </template>
            </tbody>
        </table>
        <div class="row">
            <div class="col-4">
                <div class="data-count">
                    Show {{ showFrom }} to {{ showTo }} of {{ totalCount }} rows
                </div>
            </div>
            <div class="col-8">
                <div class="pagination" v-if="totalCount > requestParams.take">
                    <a href="javascript:" :class="{'isDisabled':currentPage===1}" @click="newPage(1)">First Page</a>
                    <a href="javascript:" :class="{'isDisabled':currentPage===1}" @click="newPage(currentPage-1)">&laquo;</a>
                    <a href="javascript:" @click="newPage(page)"
                       :class="{'active isDisabled':currentPage===page,'isDisabled':page === '...'}"
                       v-for="(page,pageIndex) in pages" :key="pageIndex">{{ page }}</a>
                    <a @click="newPage(currentPage+1)" :class="{'isDisabled':currentPage===totalPage}" href="javascript:">&raquo;</a>
                    <a @click="newPage(totalPage)" :class="{'isDisabled':currentPage===totalPage}" href="javascript:">Last Page</a>
                </div>
                <div class="pagination" v-else>
                    <a href="javascript:" class="isDisabled">&laquo;</a>
                    <a href="javascript:" class="active isDisabled">1</a>
                    <a class="isDisabled" href="javascript:">&raquo;</a>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <skeleton-loader :row="14"/>
    </div>
</template>

<script>
import {Common} from "../../mixins/common";

export default {
    props: ['options'],
    mixins: [Common],
    data() {
        return {
            dataSets: [],
            requestParams: {
                take: 15,
                search: '',
                sortedType: 'asc',
                sortedKey: ''
            },
            currentPage: 1,
            pages: [],
            showDataAmount: 15,
            totalPage: 1,
            totalCount: 0,
            showTo: 0,
            showFrom: 0,
            isLoading: true
        }
    },
    mounted() {
        this.requestParams.sortedKey = this.options.columns[0].key;
        this.requestParams.sortedType = this.options.sortedType;
        this.readData();
    },
    methods: {
        sortedKeyValue(key, type) {
            this.requestParams.sortedKey = key;
            this.requestParams.sortedType = type;
            this.readData();
        },
        readData() {
            this.axiosPost(this.options.source + '?page=' + this.currentPage, this.requestParams,
                (response) => {
                    this.dataSets = response.data.data;
                    this.totalCount = response.data.total;
                    this.showTo = response.data.to;
                    this.showFrom = response.data.from;
                    this.totalPage = Math.ceil(this.totalCount / this.requestParams.take);
                    this.pages = this.pagination(this.currentPage, this.totalPage);
                    this.isLoading = false;
                },
                (error) => {
                    this.errorNoti(error);
                }
            )
        },
        search() {
            this.currentPage = 1;
            this.readData();
        },
        selectedDataAmount() {
            this.requestParams.take = this.showDataAmount;
            this.readData();
        },
        newPage(page) {
            if (page !== 0 && page <= this.totalPage) {
                this.currentPage = page;
                this.readData();
            }
        },
        pagination(c, m) {
            var delta = 2,
                range = [],
                rangeWithDots = [],
                l;

            range.push(1);
            for (let i = c - delta; i <= c + delta; i++) {
                if (i < m && i > 1) {
                    range.push(i);
                }
            }
            range.push(m);

            for (let i of range) {
                if (l) {
                    if (i - l === 2) {
                        rangeWithDots.push(l + 1);
                    } else if (i - l !== 1) {
                        rangeWithDots.push('...');
                    }
                }
                rangeWithDots.push(i);
                l = i;
            }
            return rangeWithDots;
        }
    }
}
</script>
<style>
.datatable select {
    margin: 0 5px;
}
#datatable {
    border-collapse: collapse;
    width: 100%;
}
#datatable td, #datatable th {
    border: 1px solid #ddd;
    padding: 6px;
}
#datatable tr:hover {
    background-color: #f1f1f1;
}
#datatable th {
    text-align: left;
}
.datatable .pagination {
    display: inline-block;
    margin-top: 12px;
    float: right;
}
.datatable .data-count {
    display: inline-block;
    margin-top: 12px;
}
.datatable .pagination a {
    color: black;
    float: left;
    padding: 3px 10px;
    text-decoration: none;
    transition: background-color .3s;
    border: 1px solid #ddd;
}
.datatable .pagination a.active {
    background-color: #626ed4;
    border-color: #626ed4;
    color: #fff;
}
.datatable .pagination a:hover:not(.active) {
    background-color: #ddd;
}
.datatable .isDisabled {
    cursor: not-allowed;
    opacity: 0.5;
}
thead{
  background: #333547;
  color: white;
}
</style>
