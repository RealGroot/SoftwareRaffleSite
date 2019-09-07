<template>
	<div class="custom-control custom-checkbox text-center">
		<input class="custom-control-input" :id="'raffle-check-' + suffix" type="checkbox" @change="toggleVote" v-model="isChecked"/>
		<label class="custom-control-label" :for="'raffle-check-' + suffix">I want that</label>
	</div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import Component from 'vue-class-component';
    import axios from "axios";

    interface Props {
        suffix: string,
        checked: boolean | null,
        url: string,
        payload: string
    }

    interface Data {
        isChecked: boolean
	}

    @Component({
		props: {
            suffix: String,
            checked: Boolean,
            url: String,
            payload: String
		}
	})
    export default class Vote extends Vue {
        $props!: Props;
        $data!: Data;

		data(): Data {
		    return {
                isChecked: this.$props.checked || false
			};
		}

        toggleVote(): void {
            axios.post(this.$props.url, {payload: this.$props.payload, enabled: this.$data.isChecked})
				.then(response => { console.log(`Status: ${response.status} ${response.statusText}\nData: ${response.data}`); }, reason => { console.log(reason) });
        }
    }
</script>
