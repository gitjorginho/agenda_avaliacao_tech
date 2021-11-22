<template>
  <v-container>
    <v-data-table
      :loading="loading_data_table"
      :headers="headers"
      :items="desserts"
      sort-by="corporate_name"
      class="elevation-1"
      :footer-props="{
        showFirstLastPage: true,
        itemsPerPageAllText: 'Todos',
        itemsPerPageText: 'contatos por pagina',
      }"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Contatos</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" max-width="800px" width="500">
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                color="primary"
                outlined
                dark
                class="mb-2"
                v-bind="attrs"
                v-on="on"
                >Novo contato</v-btn
              >
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-form class="px-3" @submit.prevent="submit()">
                    <v-row>
                      <v-col>
                        <v-text-field
                          dense
                          v-model="editedItem.name"
                          label="Nome"
                        ></v-text-field
                      ></v-col>
                    </v-row>
                    <v-row>
                      <v-col
                        ><v-text-field
                          dense
                          v-model="editedItem.age"
                          label="Idade"
                        ></v-text-field
                      ></v-col>
                    </v-row>
                    <div
                      v-for="telephone in editedItem.telephones"
                      :key="telephone.id"
                    >
                      <v-row>
                        <v-col
                          ><v-text-field
                            v-mask="'(##)#####-####'"
                            dense
                            v-model="telephone.telephone"
                            label="Telefone"
                          ></v-text-field
                        ></v-col>
                      </v-row>
                    </div>
                    <v-btn
                      class="mx-2"
                      dark
                      color="indigo"
                      @click="add_telephone()"
                    >
                      <v-icon dark> mdi-plus </v-icon>Telefone
                    </v-btn>
                  </v-form>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn class="mx-0 mt-3 mr-1" @click="dialog = false"
                  >Fechar</v-btn
                >
                <v-btn class="success mx-0 mt-3" @click="save"
                  >Salvar
                  <v-progress-circular
                    v-show="loading_save"
                    :size="20"
                    color="primary"
                    indeterminate
                  ></v-progress-circular
                ></v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

          <v-dialog v-model="dialogDelete" max-width="600px">
            <v-card>
              <v-card-title class="text-h5"
                >Tem certeza de que deseja excluir este contato ?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="" @click="closeDelete">Cancelar</v-btn>
                <v-btn class="primary" @click="deleteItemConfirm">OK</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon class="mr-2" @click="editItem(item)"> mdi-pencil </v-icon>
        <v-icon class="mr-2" @click="deleteItem(item)"> mdi-delete </v-icon>
      </template>
      <template v-slot:no-data> Nenhum registro encontrado </template>
    </v-data-table>
  </v-container>
</template>


<script>
import service from "./service";
export default {
  data: () => ({
    clear_attach: 0,
    loading_save: false,
    loading_data_table: false,
    dialog: false,
    dialogDelete: false,
    headers: [
      { align: "start", sortable: false, text: "Nome", value: "name" },
      { text: "Idade", value: "age" },
      { text: "", value: "actions", sortable: false },
    ],
    desserts: [],
    editedIndex: -1,
    editedItem: {
      id: "",
      name: "",
      age: "",
    },
    defaultItem: {
      id: "",
      name: "",
      age: "",
    },
  }),

  computed: {
    formTitle() {
      if (this.editedIndex === -1) {
        return "Novo Contato";
      } else {
        return "Atualizar Contato";
      }
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      this.loading_data_table = true;
      service.getAll().then((response) => {
        this.desserts = response.data;
        this.loading_data_table = false;
      });
    },

    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
      this.clear_attach++;
      delete this.editedItem.file;
    },

    deleteItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      let editedIndex = this.editedIndex;
      service.destroy(this.editedItem).then(() => {
        this.desserts.splice(editedIndex, 1);
      });

      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    save() {
      if (this.editedIndex > -1) {
        //update
        this.loading_save = true;
        let indice = this.editedIndex;
        // let array_telephones = []
        console.log(this.editedItem);
        let form = new FormData();
        for (let [key, value] of Object.entries(this.editedItem)) {
          form.append(key, value);
        }
        form.delete("telephones");
        form.append("telephones", JSON.stringify(this.editedItem.telephones));

        service
          .update(form)
          .then((response) => {
            this.loading_save = false;
            this.clear_attach++;
            this.$swal.fire({
              position: "top-end",
              icon: "success",
              title: "Contato foi salvo.",
              showConfirmButton: false,
              timer: 1500,
            });

            this.close();

            Object.assign(this.desserts[indice], response.data);
          })
          .catch((response) => {
            this.loading_save = false;
            this.errors(response.response.data);
          });
      } else {
        //store
        this.loading_save = true;
        let form = new FormData();
        for (let [key, value] of Object.entries(this.editedItem)) {
          form.append(key, value);
        }

        service
          .store(form)
          .then((response) => {
            this.loading_save = false;
            this.clear_attach++;
            this.desserts.push(response.data);

            this.$swal.fire({
              position: "top-end",
              icon: "success",
              title: "Contato foi salvo.",
              showConfirmButton: false,
              timer: 1500,
            });

            this.close();
          })
          .catch((response) => {
            this.loading_save = false;
            this.errors(response.response.data);
          });
      }
    },
    add_telephone() {
      this.editedItem.telephones.push({ telephone: "" });
    },
    errors(errors) {
      let html = "";
      for (let erro in errors) {
        html += "<p>" + errors[erro] + "</p>";
      }

      this.$swal.fire({
        position: "center",
        html: html,
        icon: "error",
        title: "Erro",
      });
    },
  },
};
</script>
