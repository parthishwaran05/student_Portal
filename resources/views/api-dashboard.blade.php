@extends('layouts.app')

@section('title', 'API Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>API Dashboard</h1>
            <p class="lead">Real-time student data fetched from REST API</p>
        </div>
    </div>

    {{-- Enhanced API Controls --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Advanced API Controls</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search students...">
                        </div>
                        <div class="col-md-3">
                            <select id="statusFilter" class="form-select">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="minMarks" class="form-control" placeholder="Min marks" min="0" max="100">
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="maxMarks" class="form-control" placeholder="Max marks" min="0" max="100">
                        </div>
                        <div class="col-md-1">
                            <button id="refreshBtn" class="btn btn-success w-100" title="Refresh">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">
                            <select id="sortBy" class="form-select">
                                <option value="">Sort by...</option>
                                <option value="name">Name</option>
                                <option value="course">Course</option>
                                <option value="marks">Marks</option>
                                <option value="created_at">Date Created</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="sortOrder" class="form-select">
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="perPage" class="form-select">
                                <option value="5">5 per page</option>
                                <option value="10" selected>10 per page</option>
                                <option value="20">20 per page</option>
                                <option value="50">50 per page</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <button id="exportCSV" class="btn btn-outline-success">
                                <i class="fas fa-download"></i> Export CSV
                            </button>
                            <button id="showJson" class="btn btn-outline-info">
                                <i class="fas fa-code"></i> Show JSON
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">API Statistics</h5>
                </div>
                <div class="card-body">
                    <p><strong>Base URL:</strong> <code>{{ url('/api') }}</code></p>
                    <p><strong>Total Students:</strong> <span id="totalStudents">0</span></p>
                    <p><strong>Active Students:</strong> <span id="activeStudents">0</span></p>
                    <p><strong>Average Marks:</strong> <span id="averageMarks">0</span></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Loading Spinner --}}
    <div id="loadingSpinner" class="text-center d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Loading student data...</p>
    </div>

    {{-- Students Table --}}
    <div id="studentsTable" class="d-none">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Marks</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="studentsTableBody">
                    {{-- Data will be populated by JavaScript --}}
                </tbody>
            </table>
        </div>
    </div>

    {{-- Empty State --}}
    <div id="emptyState" class="text-center d-none">
        <div class="alert alert-info">
            <h4>No Students Found</h4>
            <p class="mb-0">No student data is available from the API.</p>
        </div>
    </div>

    {{-- Error State --}}
    <div id="errorState" class="text-center d-none">
        <div class="alert alert-danger">
            <h4>API Error</h4>
            <p id="errorMessage" class="mb-0">Failed to load student data.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    class StudentAPI {
        constructor() {
            this.baseURL = '/api';
            this.students = [];
            this.currentData = null;
        }

        async getAllStudents(params = {}) {
            try {
                const response = await axios.get(`${this.baseURL}/students`, { params });
                this.currentData = response.data;
                return response.data;
            } catch (error) {
                throw new Error('Failed to fetch students: ' + error.message);
            }
        }

        async deleteStudent(id) {
            try {
                await axios.delete(`${this.baseURL}/students/${id}`);
                return true;
            } catch (error) {
                throw new Error('Delete failed: ' + error.message);
            }
        }
    }

    class APIDashboard {
        constructor() {
            this.api = new StudentAPI();
            this.init();
        }

        init() {
            this.bindEvents();
            this.loadStudents();
        }

        bindEvents() {
            document.getElementById('refreshBtn').addEventListener('click', () => {
                this.loadStudents();
            });

            document.getElementById('searchInput').addEventListener('input', (e) => {
                this.loadStudents();
            });

            document.getElementById('statusFilter').addEventListener('change', (e) => {
                this.loadStudents();
            });

            document.getElementById('minMarks').addEventListener('input', (e) => {
                this.loadStudents();
            });

            document.getElementById('maxMarks').addEventListener('input', (e) => {
                this.loadStudents();
            });

            document.getElementById('sortBy').addEventListener('change', (e) => {
                this.loadStudents();
            });

            document.getElementById('sortOrder').addEventListener('change', (e) => {
                this.loadStudents();
            });

            document.getElementById('perPage').addEventListener('change', (e) => {
                this.loadStudents();
            });

            document.getElementById('exportCSV').addEventListener('click', () => {
                this.exportToCSV();
            });

            document.getElementById('showJson').addEventListener('click', () => {
                this.showJSON();
            });
        }

        getFilterParams() {
            const params = {};
            
            const search = document.getElementById('searchInput').value;
            if (search) params.search = search;
            
            const status = document.getElementById('statusFilter').value;
            if (status) params.status = status;
            
            const minMarks = document.getElementById('minMarks').value;
            if (minMarks) params.min_marks = minMarks;
            
            const maxMarks = document.getElementById('maxMarks').value;
            if (maxMarks) params.max_marks = maxMarks;
            
            const sortBy = document.getElementById('sortBy').value;
            if (sortBy) params.sort_by = sortBy;
            
            const sortOrder = document.getElementById('sortOrder').value;
            if (sortBy) params.sort_order = sortOrder;
            
            const perPage = document.getElementById('perPage').value;
            if (perPage) params.per_page = perPage;
            
            return params;
        }

        async loadStudents() {
            this.showLoading();
            this.hideTable();
            this.hideEmptyState();
            this.hideError();

            try {
                const params = this.getFilterParams();
                const response = await this.api.getAllStudents(params);
                const students = response.data || response;
                this.displayStudents(students);
                this.updateStatistics(students);
            } catch (error) {
                this.showError(error.message);
            }
        }

        displayStudents(students) {
            this.hideLoading();
            
            if (!students || students.length === 0) {
                this.showEmptyState();
                return;
            }

            const tableBody = document.getElementById('studentsTableBody');
            tableBody.innerHTML = '';

            students.forEach(student => {
                const row = this.createStudentRow(student);
                tableBody.appendChild(row);
            });

            this.showTable();
        }

        updateStatistics(students) {
            const total = students.length;
            const active = students.filter(s => s.status === 'active').length;
            const avgMarks = total > 0 
                ? (students.reduce((sum, s) => sum + parseFloat(s.marks), 0) / total).toFixed(2) 
                : 0;

            document.getElementById('totalStudents').textContent = total;
            document.getElementById('activeStudents').textContent = active;
            document.getElementById('averageMarks').textContent = avgMarks;
        }

        createStudentRow(student) {
            const row = document.createElement('tr');
            
            const statusBadge = student.status === 'active' 
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-secondary">Inactive</span>';

            row.innerHTML = `
                <td>${student.id}</td>
                <td>${student.name}</td>
                <td>${student.email}</td>
                <td>${student.course}</td>
                <td>${student.marks}</td>
                <td>${statusBadge}</td>
                <td>
                    <a href="/students/${student.id}" class="btn btn-info btn-sm">View</a>
                    <button onclick="dashboard.deleteStudent(${student.id})" class="btn btn-danger btn-sm">Delete</button>
                </td>
            `;

            return row;
        }

        async deleteStudent(id) {
            if (!confirm('Are you sure you want to delete this student?')) {
                return;
            }

            try {
                await this.api.deleteStudent(id);
                this.loadStudents();
                this.showMessage('Student deleted successfully!', 'success');
            } catch (error) {
                this.showMessage('Failed to delete student: ' + error.message, 'error');
            }
        }

        exportToCSV() {
            const students = this.api.currentData?.data || [];
            if (students.length === 0) {
                alert('No data to export');
                return;
            }

            let csv = 'ID,Name,Email,Course,Marks,Status,Created At\n';
            students.forEach(student => {
                csv += `${student.id},"${student.name}","${student.email}","${student.course}",${student.marks},${student.status},"${student.created_at}"\n`;
            });

            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `students_${new Date().toISOString().slice(0,10)}.csv`;
            a.click();
            window.URL.revokeObjectURL(url);
        }

        showJSON() {
            const data = this.api.currentData;
            if (!data) {
                alert('No data available');
                return;
            }

            const jsonWindow = window.open('', '_blank');
            jsonWindow.document.write('<pre>' + JSON.stringify(data, null, 2) + '</pre>');
        }

        showMessage(message, type) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alert = document.createElement('div');
            alert.className = `alert ${alertClass} alert-dismissible fade show`;
            alert.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.querySelector('.container').insertBefore(alert, document.querySelector('.row'));
            
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }

        showLoading() {
            document.getElementById('loadingSpinner').classList.remove('d-none');
        }

        hideLoading() {
            document.getElementById('loadingSpinner').classList.add('d-none');
        }

        showTable() {
            document.getElementById('studentsTable').classList.remove('d-none');
        }

        hideTable() {
            document.getElementById('studentsTable').classList.add('d-none');
        }

        showEmptyState() {
            document.getElementById('emptyState').classList.remove('d-none');
        }

        hideEmptyState() {
            document.getElementById('emptyState').classList.add('d-none');
        }

        showError(message) {
            document.getElementById('errorMessage').textContent = message;
            document.getElementById('errorState').classList.remove('d-none');
        }

        hideError() {
            document.getElementById('errorState').classList.add('d-none');
        }
    }

    // Initialize dashboard when page loads
    const dashboard = new APIDashboard();
</script>
@endpush