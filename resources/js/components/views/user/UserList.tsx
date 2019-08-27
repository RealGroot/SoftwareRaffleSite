import React, {Component, ReactElement} from "react";
import axios from "axios";

interface State {
	pagination: any | null
}

class UserList extends Component<{}, State> {
	public constructor(props: any) {
		super(props);
		this.state = {
			pagination: null
		};
	}

	public componentDidMount(): void {
		axios.get("/api/users").then((value) => {
			this.setState({ pagination: value });
		});
	}

	public render(): ReactElement {
		if (this.state.pagination === null) {
			return (
				<></>
			);
		}
		return <></>;
	}
}

export default UserList;
