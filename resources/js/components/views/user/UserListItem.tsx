import React, {Component, ReactElement} from "react";

interface User {
	id: number,
	name: string,
	email: string,
}

interface Props {
	user: User
}

class UserListItem extends Component<Props> {
	render(): ReactElement {
		return <></>;
	}
}

export default UserListItem;
