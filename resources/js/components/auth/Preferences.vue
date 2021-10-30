  
<template>
    <div>
        <v-expansion-panels class="elevation-0" accordion>
            <v-expansion-panel>
                <v-expansion-panel-header>
                    <div class="d-flex">
                        <v-icon v-if="$vuetify.theme.isDark">fas fa-moon</v-icon>
                        <v-icon v-else>fas fa-sun</v-icon>
                        <p class="mt-4 ml-3">Modo oscuro</p>
                    </div>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <div class="my-6">
                        El modo oscuro, cambia por completo el tema usado en la aplicación por uno mucho más sobrio basado en escalas de “grises oscuros”. Es ideal para ambientes poco iluminados o para largas horas de trabajo ya que cansa menos la visión.
                    </div>
                    <v-divider></v-divider>
                    <v-row justify="space-between" class="px-3 mt-1">
                        <p class="my-6">Modo oscuro: </p>
                        <v-switch color="primary" v-model="$vuetify.theme.isDark"></v-switch>
                    </v-row>
                </v-expansion-panel-content>
            </v-expansion-panel>
            <v-expansion-panel
                v-for="(color, i) in theme.colors"
                :key="i"
            >
                <v-expansion-panel-header 
                    style="text-transform: capitalize;"
                    @click="setColor(color)"
                >
                    <div 
                        :style="`background-color: ${color.color};`"
                        class="color-indicator"
                    ></div>
                    {{ color.name }}
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <div class="my-6">
                        {{ color.description }}
                    </div>
                    <v-row justify="center">                                            
                        <v-color-picker
                            v-model="selectedColor.color"
                            mode="hexa"
                            hide-mode-switch
                            show-swatches
                            :swatches="swatches"
                        ></v-color-picker>
                    </v-row>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
    </div>
</template>

<script>
export default {
    data: () => ({
        theme: {
            dark: false,
            colors: [
                {
                    name: 'primary',
                    color: '#D81B60',
                    description: 'El color “primario” (Primary), es usado en los elementos no interactuables del sistema y para indicar ciertos elementos activos, por ejemplo, los elementos del menu lateral.'
                },
                {
                    name: 'secondary',
                    color: '#607D8B',
                    description: 'El color “secundario” (Secondary), es usado para remarcar los elementos interactuables del sistemas, tales como botones, menus, submenus, etc.'
                },
                {
                    name: 'error',
                    color: '#F44336',
                    description: 'El color “error”, no solo es usado en elementos que indican errores en el sistema, sino también en aquellos que advierten al usuario sobre la implicaciones de sus acciones.'
                },
                {
                    name: 'success',
                    color: '#4CAF50',
                    description: 'El color “éxito” (Success), es usado en elementos que indican que una operación fue realizada de forma exitosa o que hay una acción habilitada para dicho elemento.'
                },
                {
                    name: 'warning',
                    color: '#FFC107',
                    description: 'El color “advertencia” (warning), es usado, en menor medida, junto con el color “error” para advertir al usuario sobre sus futuras acciones y para indicar irregularidades en ciertos elementos.'
                }
            ]
        },

        swatches: [
            ["#FFCDD2", "#E57373", "#F44336", "#D32F2F", "#B71C1C"],
            ["#BBDEFB", "#64B5F6", "#2196F3", "#1976D2", "#0D47A1"],
            ["#C8E6C9", "#81C784", "#4CAF50", "#388E3C", "#1B5E20"],
            ["#FFECB3", "#FFD54F", "#FFC107", "#FFA000", "#FF6F00"],
            ["#263238", "#607D8B", "#D81B60", "#CDDC39", "#009688"],
        ],

        selectedColor: {name: '', color: ''},
    }),

    beforeMount() {
        for (var color in this.$vuetify.theme.themes.light) {
            let selectedIndex = this.theme.colors.indexOf(
                this.theme.colors.find(e => e.name === color )
            );
            if(this.theme.colors[selectedIndex]) {
                this.theme.colors[selectedIndex].color = this.$vuetify.theme.themes.light[color];
            }
        }
    },

    watch:{
        'selectedColor.color': function (newVal, oldVal){
            let selectedIndex = this.theme.colors.indexOf(
                this.theme.colors.find(e => e.name === this.selectedColor.name )
            );
            this.theme.colors[selectedIndex].color = this.selectedColor.color;
            this.vuetifyThemeHandler();
        },
        '$vuetify.theme.isDark'() {
            window.localStorage.setItem('isDark', JSON.stringify(this.$vuetify.theme.isDark));
        }
    },

    methods: {
        setColor(color) {
            this.selectedColor = color;
        },

        vuetifyThemeHandler() {
            for (var color in this.$vuetify.theme.themes.light) {
                if (this.$vuetify.theme.themes.light.hasOwnProperty(this.selectedColor.name)) {
                    this.$vuetify.theme.themes.light[this.selectedColor.name] = this.selectedColor.color;
                }
            }
            for (var color in this.$vuetify.theme.themes.dark) {
                if (this.$vuetify.theme.themes.dark.hasOwnProperty(this.selectedColor.name)) {
                    this.$vuetify.theme.themes.dark[this.selectedColor.name] = this.selectedColor.color;
                }
            }
            window.localStorage.setItem('customTheme', JSON.stringify(this.$vuetify.theme.themes));
        }
    }
};
</script>

<style lang="scss">

.color-indicator {
    max-width: 30px;
    height: 30px;
    border-radius: 15px;
    margin-right: 8px;
}
</style>