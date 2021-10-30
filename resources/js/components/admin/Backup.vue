<template>
    <div>
        <div class="d-flex justify-space-between">
            <div class="pa-6">
                <h3><b>Resplados</b></h3>
                <v-divider class="mt-2"></v-divider>
                <p>
                    Una copia de seguridad, respaldo, copia de respaldo o 
                    copia de reserva es una copia de los datos originales que se realiza con el 
                    fin de disponer de un medio para recuperarlos en caso de su pérdida.
                </p>
            </div>
            <v-tooltip left>
                <template v-slot:activator="{ on }">
                    <v-btn
                        color="primary"
                        dark
                        fab
                        class="elevation-0 mb-2 mt-7 mx-4"
                        :loading="inProcess"
                        v-on="on"
                        @click="generateBackup()"
                    >
                        <v-icon>fas fa-cloud-download-alt</v-icon>
                    </v-btn>
                </template>
                <span>Generar respaldo</span>
            </v-tooltip>
        </div>
        <v-divider></v-divider>
        <div v-if="backups && backups.length > 0">
            <div v-for="(backup, id) in backups" :key="id">
                <v-list-item two-line>
                    <v-list-item-content>
                        <v-list-item-title>{{ backup.date }}</v-list-item-title>
                        <v-list-item-subtitle>{{ backup.name }}</v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-icon class="mt-8" @click="dowloadBackup(backup.id)" style="cursor: pointer;">
                        <v-icon color="primary">fas fa-file-download</v-icon>
                    </v-list-item-icon>
                </v-list-item>
                <v-divider></v-divider>
            </div>
        </div>
        <div v-else class="mt-4">
            <p class="text-center">No hay respaldos generados</p>
        </div>
    </div>
</template>

<script>
import dayjs from 'dayjs';

export default {
    data: () => ({
        inProcess: false,
        backups: []
    }),

    mounted() {
        this.getBackup();
    },

    methods: {
        getBackup() {
            this.inProcess = true;
            axios.get("/api/backup/all").then(response => {
                this.inProcess = false;
                this.backups = response.data.sort(function(a, b) { 
                    return b.id - a.id;
                });
            }).catch(error => {
                this.$store.dispatch("errorHandle", error.response, {
                    root: true
                });
                console.log(error.response);
                this.inProcess = false;
            });
        },

        dowloadBackup(id) {
            this.inProcess = true;
            axios({
                url: `/api/backup/get/${id}`,
                method: "GET",
                responseType: "blob"
            })
                .then(response => {
                    let url = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    let link = document.createElement("a");
                    link.href = url;
                    link.setAttribute(
                        "download",
                        `backup_${dayjs().format('DD_MM_YYYY hh_mm')}.sql`
                    );
                    document.body.appendChild(link);
                    link.click();
                    this.inProcess = false;
                })
                .catch(error => {
                    this.$store.dispatch("errorHandle", error.response, {
                        root: true
                    });
                    console.log(error.response);
                    this.inProcess = false;
                });
            
        },

        generateBackup() {
            this.inProcess = true;
            axios({
                url: "/api/backup/generate",
                method: "GET",
                responseType: "blob"
            })
                .then(response => {
                    let url = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    let link = document.createElement("a");
                    link.href = url;
                    link.setAttribute(
                        "download",
                        `backup_${dayjs().format('DD_MM_YYYY hh_mm')}.sql`
                    );
                    document.body.appendChild(link);
                    link.click();
                    this.getBackup();
                })
                .catch(error => {
                    this.$store.dispatch("errorHandle", error.response, {
                        root: true
                    });
                    console.log(error.response);
                    this.inProcess = false;
                });
        }
    }
}
</script>