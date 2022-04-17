/*
	selectFile.js v1.0
	(c) 2017 by Thielicious
	
	A JavaScript function which lets you customize the browse button and its selection text. 
	This function simply emulates the browse button using an ordinary input button as a trigger.
*/


const selectFile = function() {
	
	let regex = /[^\\]+$/
	
	this.choose,
	this.selected
	
	this.msg = str => {
		let prefix = '[selectFile.js]\n\nError: '
		return alert(prefix+str)
	}
		
	this.check = () => {
		if (this.choose && this.selected != null) {
			let choose = document.getElementById(this.choose),
				selected = document.getElementById(this.selected)
			choose.addEventListener('change',() => {
				if (choose.value != '') { 
					selected.innerHTML = choose.value.match(regex)
				}
			})
		} else {
			this.msg('Targets not set.')
		}
	}
	
	selectFile.prototype.targets = (trigger, filetext) => {
		this.choose = trigger
		this.selected = filetext
	}
	
	selectFile.prototype.simulate = () => {
		if (this.choose != null) {
			let choose = document.getElementById(this.choose)
			if (typeof choose != 'undefined') {
				choose.click()
				this.check()
			} else {
				this.msg('Could not find element '+this.choose)
			}
		} else {
			this.msg('Targets not set.')
		}
	}	
	
};

const selectFile1 = function() {
	
	let regex = /[^\\]+$/
	
	this.chooseCoE,
	this.selectedCoE
	
	this.msg = str => {
		let prefix = '[selectFile.js]\n\nError: '
		return alert(prefix+str)
	}
		
	this.check = () => {
		if (this.chooseCoE && this.selectedCoE != null) {
			let chooseCoE = document.getElementById(this.chooseCoE),
				selectedCoE = document.getElementById(this.selectedCoE)
			chooseCoE.addEventListener('change',() => {
				if (chooseCoE.value != '') { 
					selectedCoE.innerHTML = chooseCoE.value.match(regex)
				}
			})
		} else {
			this.msg('Targets not set.')
		}
	}
	
	selectFile1.prototype.targets = (trigger, filetext) => {
		this.chooseCoE = trigger
		this.selectedCoE = filetext
	}
	
	selectFile1.prototype.simulate = () => {
		if (this.chooseCoE != null) {
			let chooseCoE = document.getElementById(this.chooseCoE)
			if (typeof chooseCoE != 'undefined') {
				chooseCoE.click()
				this.check()
			} else {
				this.msg('Could not find element '+this.chooseCoE)
			}
		} else {
			this.msg('Targets not set.')
		}
	}	
	
};

const selectFile2 = function() {
	
	let regex = /[^\\]+$/
	
	this.chooseED,
	this.selectedED
	
	this.msg = str => {
		let prefix = '[selectFile.js]\n\nError: '
		return alert(prefix+str)
	}
		
	this.check = () => {
		if (this.chooseED && this.selectedED != null) {
			let chooseED = document.getElementById(this.chooseED),
				selectedED = document.getElementById(this.selectedED)
			chooseED.addEventListener('change',() => {
				if (chooseED.value != '') { 
					selectedED.innerHTML = chooseED.value.match(regex)
				}
			})
		} else {
			this.msg('Targets not set.')
		}
	}
	
	selectFile2.prototype.targets = (trigger, filetext) => {
		this.chooseED = trigger
		this.selectedED = filetext
	}
	
	selectFile2.prototype.simulate = () => {
		if (this.chooseED != null) {
			let chooseED = document.getElementById(this.chooseED)
			if (typeof chooseED != 'undefined') {
				chooseED.click()
				this.check()
			} else {
				this.msg('Could not find element '+this.chooseED)
			}
		} else {
			this.msg('Targets not set.')
		}
	}	
	
};

const selectFile3 = function() {
	
	let regex = /[^\\]+$/
	
	this.chooseCV,
	this.selectedCV
	
	this.msg = str => {
		let prefix = '[selectFile.js]\n\nError: '
		return alert(prefix+str)
	}
		
	this.check = () => {
		if (this.chooseCV && this.selectedCV != null) {
			let chooseCV = document.getElementById(this.chooseCV),
			selectedCV = document.getElementById(this.selectedCV)
				chooseCV.addEventListener('change',() => {
				if (chooseCV.value != '') { 
					selectedCV.innerHTML = chooseCV.value.match(regex)
				}
			})
		} else {
			this.msg('Targets not set.')
		}
	}
	
	selectFile3.prototype.targets = (trigger, filetext) => {
		this.chooseCV = trigger
		this.selectedCV = filetext
	}
	
	selectFile3.prototype.simulate = () => {
		if (this.chooseCV != null) {
			let chooseCV = document.getElementById(this.chooseCV)
			if (typeof chooseCV != 'undefined') {
				chooseCV.click()
				this.check()
			} else {
				this.msg('Could not find element '+this.chooseCV)
			}
		} else {
			this.msg('Targets not set.')
		}
	}	
	
};

const selectFile4 = function() {
	
	let regex = /[^\\]+$/
	
	this.choosePubl,
	this.selectedPubl
	
	this.msg = str => {
		let prefix = '[selectFile.js]\n\nError: '
		return alert(prefix+str)
	}
		
	this.check = () => {
		if (this.choosePubl && this.selectedPubl != null) {
			let choosePubl = document.getElementById(this.choosePubl),
			selectedPubl = document.getElementById(this.selectedPubl)
			choosePubl.addEventListener('change',() => {
				if (choosePubl.value != '') { 
					selectedPubl.innerHTML = choosePubl.value.match(regex)
				}
			})
		} else {
			this.msg('Targets not set.')
		}
	}
	
	selectFile4.prototype.targets = (trigger, filetext) => {
		this.choosePubl = trigger
		this.selectedPubl = filetext
	}
	
	selectFile4.prototype.simulate = () => {
		if (this.choosePubl != null) {
			let choosePubl = document.getElementById(this.choosePubl)
			if (typeof choosePubl != 'undefined') {
				choosePubl.click()
				this.check()
			} else {
				this.msg('Could not find element '+this.choosePubl)
			}
		} else {
			this.msg('Targets not set.')
		}
	}	
	
};

const selectFile5 = function() {
	
	let regex = /[^\\]+$/
	
	this.chooseNL,
	this.selectedNL
	
	this.msg = str => {
		let prefix = '[selectFile.js]\n\nError: '
		return alert(prefix+str)
	}
		
	this.check = () => {
		if (this.chooseNL && this.selectedNL != null) {
			let chooseNL = document.getElementById(this.chooseNL),
			selectedNL = document.getElementById(this.selectedNL)
			chooseNL.addEventListener('change',() => {
				if (chooseNL.value != '') { 
					selectedNL.innerHTML = chooseNL.value.match(regex)
				}
			})
		} else {
			this.msg('Targets not set.')
		}
	}
	
	selectFile5.prototype.targets = (trigger, filetext) => {
		this.chooseNL = trigger
		this.selectedNL = filetext
	}
	
	selectFile5.prototype.simulate = () => {
		if (this.chooseNL != null) {
			let chooseNL = document.getElementById(this.chooseNL)
			if (typeof chooseNL != 'undefined') {
				chooseNL.click()
				this.check()
			} else {
				this.msg('Could not find element '+this.chooseNL)
			}
		} else {
			this.msg('Targets not set.')
		}
	}	
	
};

const selectFile6 = function() {
	
	let regex = /[^\\]+$/
	
	this.chooseTranscript,
	this.selectedTranscript
	
	this.msg = str => {
		let prefix = '[selectFile.js]\n\nError: '
		return alert(prefix+str)
	}
		
	this.check = () => {
		if (this.chooseTranscript && this.selectedTranscript != null) {
			let chooseTranscript = document.getElementById(this.chooseTranscript),
			selectedTranscript = document.getElementById(this.selectedTranscript)
			chooseTranscript.addEventListener('change',() => {
				if (chooseTranscript.value != '') { 
					selectedTranscript.innerHTML = chooseTranscript.value.match(regex)
				}
			})
		} else {
			this.msg('Targets not set.')
		}
	}
	
	selectFile6.prototype.targets = (trigger, filetext) => {
		this.chooseTranscript = trigger
		this.selectedTranscript = filetext
	}
	
	selectFile6.prototype.simulate = () => {
		if (this.chooseTranscript != null) {
			let chooseTranscript = document.getElementById(this.chooseTranscript)
			if (typeof chooseTranscript != 'undefined') {
				chooseTranscript.click()
				this.check()
			} else {
				this.msg('Could not find element '+this.chooseTranscript)
			}
		} else {
			this.msg('Targets not set.')
		}
	}	
	
};

const selectFile7 = function() {
	
	let regex = /[^\\]+$/
	
	this.chooseAgreement,
	this.selectedAgreement
	
	this.msg = str => {
		let prefix = '[selectFile.js]\n\nError: '
		return alert(prefix+str)
	}
		
	this.check = () => {
		if (this.chooseAgreement && this.selectedAgreement != null) {
			let chooseAgreement = document.getElementById(this.chooseAgreement),
			selectedAgreement = document.getElementById(this.selectedAgreement)
			chooseAgreement.addEventListener('change',() => {
				if (chooseAgreement.value != '') { 
					selectedAgreement.innerHTML = chooseAgreement.value.match(regex)
				}
			})
		} else {
			this.msg('Targets not set.')
		}
	}
	
	selectFile7.prototype.targets = (trigger, filetext) => {
		this.chooseAgreement = trigger
		this.selectedAgreement = filetext
	}
	
	selectFile7.prototype.simulate = () => {
		if (this.chooseAgreement != null) {
			let chooseAgreement = document.getElementById(this.chooseAgreement)
			if (typeof chooseAgreement != 'undefined') {
				chooseAgreement.click()
				this.check()
			} else {
				this.msg('Could not find element '+this.chooseAgreement)
			}
		} else {
			this.msg('Targets not set.')
		}
	}	
	
};