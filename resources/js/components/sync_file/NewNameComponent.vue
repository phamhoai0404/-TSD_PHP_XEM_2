<template>
    <v-dialog
            id="diglog_comfirm"
            v-model="isOpen"
            max-width="480"
    >
        <v-card id="confirm">
            <v-card-title class="headline">{{ $t('message.alert.input_file_name') }}</v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12>
                            <v-text-field v-model="newName"></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn
                        color="red darken-1"
                        flat="flat"
                        @click="$emit('save', { confirm: false })"
                >
                    {{ $t('message.alert.donot') }}
                </v-btn>
                <v-btn
                        color="green darken-1"
                        flat="flat"
                        @click="$emit('save', { confirm: true, newName: newName})"
                >
                    {{ $t('message.alert.save') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default{
        name: 'NewName',
        props: {
            oldItemName: String,
            prefix: String
        },
        data() {
            return {
                isOpen: true,
                newName: this.oldItemName
            }
        },
        watch: {
            isOpen() {
                this.$emit('close');
            }
        }
    }
</script>
<style >
</style>